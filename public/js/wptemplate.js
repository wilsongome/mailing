
function handleHeaderParameter(selectedValue)
{
    if(selectedValue == "text"){
        document.getElementById("staticHeaderValue").disabled = false;
    }

    if(selectedValue != "text"){
        document.getElementById("staticHeaderValue").disabled = true;
    }
}

function handleParameter()
{
    let typeObject = document.getElementById("parameterType");
    let dataFromObject = document.getElementById("parameterDataFrom");
    let dataTypeObject = document.getElementById("parameterDataType");

    let staticParameterValueObject = document.getElementById("staticParameterValue");
    let mediaFileObject = document.getElementById("mediaFile");

    var type = typeObject.options[typeObject.selectedIndex].value;
    var dataFrom = dataFromObject.options[dataFromObject.selectedIndex].value;
    var dataType = dataTypeObject.options[dataTypeObject.selectedIndex].value;

    if(dataFrom == "static" &&  dataType == "text"){
        staticParameterValueObject.disabled = false;
    }
    if(!(dataFrom == "static" &&  dataType == "text")){
        staticParameterValueObject.disabled = true;
    }

    if(type == "header" &&  dataFrom == "static" && dataType !="text" && dataType !=""){
        mediaFileObject.disabled = false;
    }
    if(!(type == "header" &&  dataFrom == "static" && dataType !="text" && dataType !="")){
        mediaFileObject.disabled = true;
    }


   /*  if(dataFrom != "static" &&  dataType != "text"){
        staticParameterValueObject.disabled = true;
    }

    if(dataFrom == "static" &&  dataType != "text" && type == "head"){
        staticParameterValueObject.disabled = true;
        mediaFileObject.disabled = false;
    } */

    console.log(type + " " + dataFrom + " " + dataType);


    
}