function plusOrMinus(code)
{
    var acc = 0;
    var output = "";
    for(var i = 0; i < code.length; ++i)
    {
        if(code[i] === "+")
        {
            ++acc;
            if(acc > 255)
                acc = 0;
        }
        else if(code[i] === "-")
        {
            output += String.fromCharCode(acc);
            --acc;
            if(acc < 0)
                acc = 255;
        }
    }
    return output;
}
