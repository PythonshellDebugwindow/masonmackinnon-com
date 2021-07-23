if(!Math.log2)
{
    Math.log2 = function(x)
    {
        return Math.log(x) * Math.LOG2E;
    };
}

function base2(code)
{
	var cellA = Math.random() >= 0.5;
	var cellB = Math.random() >= 0.5;
	var codeHasError = false;
	var output = "";
	code = code.split("\n");
	
	/* This cellSequence function has to be here, else the cells would have to
	be passed as parameters */
	function cellSequence(str)
	{
		var result = 0;
		var curn = 0;
		var curp = 1;
		for(var i = 0; i < str.length; i++)
		{
			if(str.charAt(i) == "A")
			    curn = cellA ? 1 : 0;
			else if(str.charAt(i) == "B")
			    curn = cellB ? 1 : 0;
			else
			    return -1;
			result += curn * curp;
			curp *= 2;
		}
		return result;
	}
	
	//There must be 2^n lines (instructions) in each program
	if(Math.log2(code.length) % 1 !== 0)
	{
		console.log("Error: not 2^n lines");
		return;
	}
	
	for(var index = 0, i = null; index < code.length; ++index)
	{
	    i = code[index];
	    
		if(codeHasError)
		    break;
		
		if(i === "")
			break;
		
		i = i.split(" ");
		switch(i[0])
		{
			case "set":
				if(i.length === 1)
				{
					codeHasError = true;
					break;
				}
				if(i[1] === "A")
					cellA = true;
				else if(i[1] === "B")
					cellB = true;
				break;
			case "offset":
				if(i[1] === "A")
					cellA = !cellA;
				else if(i[1] === "B")
					cellB = !cellB;
				break;
			case "swap":
				let temp = cellA;
				cellA = cellB;
				cellB = temp;
				break;
			case "yell":
				if(i.length === 1)
				{
					codeHasError = true;
					break;
				}
				if(i[1] == "A")
					output += cellA ? "true" : "ntrue";
				else if(i[1] == "B")
					output += cellB ? "true" : "ntrue";
				break;
			case "scream":
				if(i.length === 1)
				{
					codeHasError = true;
					return;
				}
				if(cellSequence(i[1]) != -1)
				    output += String.fromCharCode(cellSequence(i[1]));
				break;
			case "doorbell":
				if(i.length === 1 || cellSequence(i[i.length - 1]) === -1)
				{
					codeHasError = true;
					return;
				}
				for(let j = 0; j < cellSequence(i[1]); j++)
				{
					output += "Ding-dong\n";
				}
				break;
			default:
				if((i[0] !== "true" && i[0] !== "ntrue" && i[0])
				   || cellSequence(i[0]) === -1)
				{
					codeHasError = true;
					return;
				}
		}
		for(let j = 1; j < i.length; j++)
		{
			if(i[j] != "true" && i[j] != "ntrue" && cellSequence(i[j]) == -1)
			{
				codeHasError = true;
				return;
			}
		}
	}
	
	if(codeHasError)
		output = "Error";
	return output;
}
