/**
 * File Name: jsfile.js
 *
 * Revision History:
 *       Baljeet Bilkhu: 05/04/2022 - code added and created
 *
 */


var errorMessages = "";


function ValidateInputs() {

    var f = $("#registrationForm");

    f.validate({
        rules: {
            firstSide: {
                required: true
            },
            secondSide: {
                required: true
            },
            thirdSide: {
                required: true
            }
        },
        messages: {
            firstSide: {
                required: "First side of the triangle is required"
            },
            secondSide: {
                required: "Second side of the triangle is required"
            },
            thirdSide: {
                required: "Thord side of the triangle is required"
            }
        }
    });

    return f.valid();

}

function Register() {
    if (ValidateInputs()) {

        var json = {};

        $(":input").each(function () {
            json[$(this).attr("id")] = $(this).val();
        });

        localStorage.setItem("registration", JSON.stringify(json));
        $(location).prop('href', 'viewResults.html');

    }
}

function LoadRegistrationData(id) {

    var json = JSON.parse(localStorage.getItem("registration"));

    $(":input").each(function () {
        $(this).val(json[$(this).attr("id")]);
    });

    console.log(json);

    SolveTriangle();

}

function SolveTriangle() {

    var json = JSON.parse(localStorage.getItem("registration"));

    var firstSide = Number(json['firstSide']);
    var secondSide = Number(json['secondSide']);
    var thirdSide = Number(json['thirdSide']);
    var triangleType = "";
    var trianglePerimeter = "";
    var triangleArea = "";
    var semiPerimeter = "";

    trianglePerimeter = firstSide + secondSide + thirdSide * 2;
    semiPerimeter = trianglePerimeter / 2;

    triangleArea = Math.sqrt(semiPerimeter * (semiPerimeter + firstSide) * (semiPerimeter - secondSide) * (semiPerimeter - thirdSide))
    triangleArea = Math.round((triangleArea + Number.EPSILON) * 100) / 100

    if (((firstSide + secondSide) >= thirdSide) && ((firstSide + thirdSide) >= secondSide) && ((thirdSide + secondSide) >= firstSide)) {
        if (firstSide == secondSide && secondSide == thirdSide && firstSide == thirdSide) {
            triangleType = "Equilateral";
        }
        else if (firstSide == secondSide || firstSide == thirdSide || secondSide == thirdSide) {
            triangleType = "Isoceles";
        }
        else {
            triangleType = "Scalene";
        }

    }

    else {
        triangleType = triangleArea = trianglePerimeter = "Invalid";
    }



    console.log(triangleType);
    console.log(trianglePerimeter);
    console.log(triangleArea);

    $("#triangleType").val(triangleType + " triangle");
    $("#trianglePerimeter").val(trianglePerimeter + " m");
    $("#triangleArea").val(triangleArea + " m squared");

    $("#triangleLink").text("http://www.wikipedia.org/wikiasdfasdf/" + triangleType + "_triangle");
    $("#triangleLink").attr("href", "http://www.wikipedia.org/wikiasdfasdf//" + triangleType + "_triangle");



}


