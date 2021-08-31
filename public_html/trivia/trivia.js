const curQuestionDisplay = document.getElementById("cur-question");
const questionTextDisplay = document.getElementById("question-text");
const questionsDiv = document.getElementById("questions");
const numAnswersPerQuestion = 4;

var curCorrectAnswer = -1;
var curQuestion = 0;
var numQuestionsAnswered = 0;
var score = 0;
var canSelectAnswer = true;

//questions and numQuestions are set in index.php, as they need inline PHP

function updateHtmlForNthQuestion(n)
{
    curQuestionDisplay.innerText = n + 1;
    questionTextDisplay.innerText = questions[n].question;
    
    for(let i = 0; i < numAnswersPerQuestion; ++i)
    {
        let answerDiv = questionsDiv.children[i];
        answerDiv.classList.remove("guess-right");
        answerDiv.classList.remove("guess-wrong");
        let span = answerDiv.children[0];
        span.innerText = questions[n]["ans" + (i + 1)];
        answerDiv.onclick = makeHandleNthQuestionClicked(i);
    }
    
    curCorrectAnswer = parseInt(questions[n].correct);
}

function makeHandleNthQuestionClicked(i)
{
    return function()
    {
        handleNthQuestionClicked(i);
    };
}

function handleNthQuestionClicked(n)
{
    if(!canSelectAnswer)
        return;
    
    ++numQuestionsAnswered;
    canSelectAnswer = false;
    
    if(n + 1 === curCorrectAnswer)
    {
        questionsDiv.children[n].classList.add("guess-right");
        ++score;
    }
    else
    {
        questionsDiv.children[n].classList.add("guess-wrong");
        questionsDiv.children[curCorrectAnswer - 1].classList.add("guess-right");
    }
    
    setTimeout(function() {
        canSelectAnswer = true;
        ++curQuestion;
        if(curQuestion < questions.length)
            updateHtmlForNthQuestion(curQuestion);
        else
            endGame();
    }, 500);
}

function endGame()
{
    curQuestionDisplay.parentElement.remove();
    questionTextDisplay.innerText = "";
    removeAllQuestionsFromDocument();
    questionsDiv.classList.remove("questions");
    questionsDiv.classList.add("endgame");
    
    let percent = numQuestionsAnswered > 0 ? Math.round((score / numQuestionsAnswered) * 100) : 0;
    let msg = "You got " + score + "/" + numQuestionsAnswered + " (" + percent + "%)";
    let msgDisplay = document.createElement("h2");
    msgDisplay.innerText = msg;
    questionsDiv.appendChild(msgDisplay);
}

if(false)
document.getElementById("end").onclick = function()
{
    endGame();
};

function removeAllQuestionsFromDocument()
{
    while(questionsDiv.childElementCount > 0)
        questionsDiv.children[0].remove();
}

updateHtmlForNthQuestion(curQuestion);
