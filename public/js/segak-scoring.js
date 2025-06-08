$(() => {

    // to do list
    // this scripts sepatutnya kena compare gender and age!


    // Example scoring rules (adjust as needed)
    function getScore(val, max) {
        if (val >= max) return 5;
        if (val >= max * 0.8) return 4;
        if (val >= max * 0.6) return 3;
        if (val >= max * 0.4) return 2;
        if (val > 0) return 1;
        return 0;
    }

    // Example max values (adjust as needed)
    const maxStepTest = 40;
    const maxPushUp = 30;
    const maxSitUp = 30;
    const maxSitReach = 40;

    function updateScores() {
        // Step Test
        let stepTest = parseInt($("#step_test_steps").val()) || 0;
        let stepTestScore = getScore(stepTest, maxStepTest);
        $("#step_test_score").val(stepTestScore);

        // Push Up
        let pushUp = parseInt($("#push_up_steps").val()) || 0;
        let pushUpScore = getScore(pushUp, maxPushUp);
        $("#push_up_score").val(pushUpScore);

        // Sit Up
        let sitUp = parseInt($("#sit_up_steps").val()) || 0;
        let sitUpScore = getScore(sitUp, maxSitUp);
        $("#sit_up_score").val(sitUpScore);

        // Sit and Reach
        let sitReach = parseFloat($("#sit_and_reach").val()) || 0;
        let sitReachScore = getScore(sitReach, maxSitReach);
        // If you want to show sit_and_reach_score in a field, add an input and set its value here
        $("#sit_and_reach_score").val(sitReachScore);

        // Total Score
        let total = stepTestScore + pushUpScore + sitUpScore + sitReachScore;
        $("#total_score").val(total);

        // Gred (example: A for 18-20, B for 14-17, C for 10-13, D for less)
        let gred = "";
        if (total >= 18) gred = "A";
        else if (total >= 14) gred = "B";
        else if (total >= 10) gred = "C";
        else gred = "D";
        $("#gred").val(gred);
    }

    $("#step_test_steps, #push_up_steps, #sit_up_steps, #sit_and_reach").on(
        "input",
        updateScores
    );

    // Trigger once on page load
    updateScores();
});
