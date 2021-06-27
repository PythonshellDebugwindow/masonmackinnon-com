<?php
    $title = 'Trivia';
    $styles = array('trivia');
    include_once("../../includes/header.php");
?>
<section>
    <h1 class="center-text darkred bigger">Trivia</h1>
    <?php
        function fail()
        {
            echo '<p>Error: `' . mysqli_error($dbc) . " " . mysqli_errno() . '`</p>';
            die();
        }
        
        function to_json($val)
        {
            if(!is_array($val))
                return "\"$val\"";
            
            $res = "{";
            foreach($val as $k => $v)
                $res .= to_json($k) . ": " . to_json($v) . ", ";
            //Remove final ", "
            $res = substr($res, 0, strlen($res) - 2);
            $res .= "}";
            return $res;
        }
        
        require('../../connect_db.php');
        $dbc = connect();
        if(mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        
        $r = mysqli_query($dbc, 'USE trivia');
        if(!$r)
            fail();
        
        $r = mysqli_query($dbc, 'SELECT NULL FROM trivia_questions');
        if(!$r)
            fail();
        
        $numQuestionsInDb = mysqli_num_rows($r);
        
        $shouldPlay = $_SERVER['REQUEST_METHOD'] == 'POST';
        //Validate number of questions
        if($shouldPlay)
        {
            if(!isset($_POST['num-questions']) || !ctype_digit($_POST['num-questions']))
            {
                $shouldPlay = false;
                echo '<p class="error">Error: Invalid number of questions</p>';
            }
        }
        $numQuestions = 0;
        //Play the game
        if($shouldPlay)
        {
            $numQuestions = intval($_POST['num-questions']);
            
            $questions = array();
            $questionIds = range(1, $numQuestions);
            shuffle($questionIds);
            
            foreach($questionIds as $id)
            {
                $r = mysqli_query($dbc, "SELECT * FROM trivia_questions WHERE id = $id");
                if(!$r)
                    fail();
                
                $questions[] = mysqli_fetch_array($r, MYSQLI_ASSOC);
            }
            mysqli_close($dbc);
        ?>
            <div>
                <h2>Question: <span id="cur-question">0</span>/<?php echo $numQuestions; ?></h2>
               
            </div>
            <h2 id="question-text"></h2>
            <div class="questions" id="questions">
                <div class="answer"><span>A</span></div>
                <div class="answer"><span>B</span></div>
                <div class="answer"><span>C</span></div>
                <div class="answer"><span>D</span></div>
            </div>
            
            <script>
                const numQuestions = <?php echo $numQuestions; ?>;
                var questions = [];
                <?php
                    foreach($questions as $question)
                        echo 'questions.push(' . to_json($question) . ");\n";
                ?>
                console.log(questions);
            </script>
            <script src="trivia.js"></script>
            <?php
        }
        //Not POST or invalid number of questions
        else
        {
        ?>
        <p class="justify">This is a trivia game. You are shown a series of questions, each with four possible answers; you have to pick the correct one.</p>
        
        <form action="#" method="POST">
            <label>
                Enter number of questions:
                <input type="number" name="num-questions" min="1" max="<?php echo $numQuestionsInDb; ?>" value="30">
            </label>
            <input type="submit" value="Play">
        </form>
    <?php } ?>
</section>
<?php include_once('../../includes/footer.php'); ?>
