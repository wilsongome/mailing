
function handleHeaderParameter(selectedValue)
{
    let mediaFileObject = document.getElementById("mediaFile");
    let staticHeaderValueObject = document.getElementById("staticHeaderValue");

    if(selectedValue == "text"){
        staticHeaderValueObject.disabled = false;
        mediaFileObject.disabled = true;
    }

    if(selectedValue != "text"){
        staticHeaderValueObject.disabled = true;
        staticHeaderValueObject.value = "";
        mediaFileObject.disabled = false;
    }
}

function handleParameter()
{
    let dataFromObject = document.getElementById("parameterDataFrom");
    let staticParameterValueObject = document.getElementById("staticParameterValue");
    var dataFrom = dataFromObject.options[dataFromObject.selectedIndex].value;

    if(dataFrom == "static"){
        staticParameterValueObject.disabled = false;
    }
    if(!(dataFrom == "static")){
        staticParameterValueObject.disabled = true;
        staticParameterValueObject.value = "";
    }
    
}