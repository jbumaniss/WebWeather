<?php

use App\Models\WeatherData;

test("WeatherData model test", function () {
    $weather = new WeatherData(
        "2022-07-22 17:00",
        31.1,
        52.1,
        "//www.google.com/imgres?imgurl=https%3A%2F%2Fcdn-icons-png.flaticon.com%2F512%2F1354%2F1354217.png&imgrefurl=https%3A%2F%2Fwww.flaticon.com%2Fpremium-icon%2Ftesting_1354217&tbnid=UXlKlh_DmCydAM&vet=12ahUKEwjr4cfV0oz5AhVtx4sKHSB5ApgQMygAegUIARCjAQ..i&docid=m1HRYiJIL59G5M&w=512&h=512&q=icon%20url%20for%20testing&ved=2ahUKEwjr4cfV0oz5AhVtx4sKHSB5ApgQMygAegUIARCjAQ"
    );
    expect($weather->getDate())->toBe("2022-07-22 17:00");
    expect($weather->getTemperature())->toBe(31.1);
    expect($weather->getHumidity())->toBe(52.1);
    expect($weather->getIcon())->toBe("//www.google.com/imgres?imgurl=https%3A%2F%2Fcdn-icons-png.flaticon.com%2F512%2F1354%2F1354217.png&imgrefurl=https%3A%2F%2Fwww.flaticon.com%2Fpremium-icon%2Ftesting_1354217&tbnid=UXlKlh_DmCydAM&vet=12ahUKEwjr4cfV0oz5AhVtx4sKHSB5ApgQMygAegUIARCjAQ..i&docid=m1HRYiJIL59G5M&w=512&h=512&q=icon%20url%20for%20testing&ved=2ahUKEwjr4cfV0oz5AhVtx4sKHSB5ApgQMygAegUIARCjAQ");
});