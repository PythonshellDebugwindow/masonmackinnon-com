function depend(code)
{
    var output = "";
    code = code.split("\n");
    var events = {};
    var m, tmp, i;
    var lineRegex = /^([A-Za-z0-9_]+)->((?:[A-Za-z0-9_]+,)*[A-Za-z0-9_]+|)$/;
    for(i = 0; i < code.length; ++i)
    {
        var line = code[i];
        m = line.match(lineRegex);
        if(m)
        {
            mp = m[2].split(",").filter(d => !!d);
            if(events.hasOwnProperty(m[1]))
                events[m[1]] += tmp;
            else
                events[m[1]] = tmp;
        }
        else if(line !== "" && line.substring(0, 2) !== "->")
            return "Invalid syntax";
    }
    console.log(events)
    while(Object.keys(events).length !== 0)
    {
        var eventKeys = Object.keys(events);
        for(i = 0; i < eventKeys.length; ++i)
        {
            console.log('a')
            output+=eventKeys[i]+": "+events[eventKeys[i]]+"\n";
            var event = eventKeys[i];
            console.log(events,event)
            if(events[event].length === 0)
                delete events[event];
            else
                for(var j = 0; j < events[event].length; ++j)
                    if(!events.hasOwnProperty(events[event][j]))
                        events[event].splice(events[event].indexOf(events[event][j]), 1);
        }
        output+="\n";
    }
    return output;
}
