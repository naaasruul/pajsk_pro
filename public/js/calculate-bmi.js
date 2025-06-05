$(() => {
               
                var bmiStatus = $('#bmi_status');
                var bmi_score = 0;
                const bmiThresholds = {
                    male: {
                        13: {
                            under: 15.0,
                            normal: [15.0, 21.0],
                            over: [21.1, 25.0]
                        }, // example values
                        14: {
                            under: 15.5,
                            normal: [15.5, 22.0],
                            over: [22.1, 26.0]
                        },
                        15: {
                            under: 16.0,
                            normal: [16.0, 23.0],
                            over: [23.1, 27.0]
                        },
                        16: {
                            under: 16.5,
                            normal: [16.5, 24.0],
                            over: [24.1, 28.0]
                        },
                        17: {
                            under: 17.0,
                            normal: [17.0, 25.0],
                            over: [25.1, 29.0]
                        }
                    },
                    female: {
                        13: {
                            under: 14.8,
                            normal: [14.9, 20.8],
                            over: [20.9, 24.8]
                        },
                        14: {
                            under: 15.4,
                            normal: [15.5, 21.8],
                            over: [21.9, 25.9]
                        },
                        15: {
                            under: 15.9,
                            normal: [16.0, 22.7],
                            over: [22.8, 27.0]
                        },
                        16: {
                            under: 16.4,
                            normal: [16.5, 23.5],
                            over: [23.6, 27.9]
                        },
                        17: {
                            under: 16.8,
                            normal: [16.9, 24.3],
                            over: [24.4, 28.6]
                        }
                    }
                };

                $('#weight, #height').on('input', function() {
                    var weight = parseFloat($('#weight').val());
                    var height = parseFloat($('#height').val()) / 100; // Convert cm to meters
                    if (weight > 0 && height > 0) {
                        bmi_score = weight / (height * height);
                        bmi_score = parseFloat(bmi_score.toFixed(2)); // Round to 2 decimal places

                        let thresholds = bmiThresholds[student_gender] && bmiThresholds[student_gender][
                            student_age
                        ];
                        if (thresholds) {
                            if (bmi_score < thresholds.under) {
                                bmiStatus.val('Underweight');
                            } else if (bmi_score >= thresholds.normal[0] && bmi_score <= thresholds.normal[1]) {
                                bmiStatus.val('Normal weight');
                            } else if (bmi_score >= thresholds.over[0] &&
                                bmi_score <= thresholds.over[1]) {
                                bmiStatus.val('Overweight');
                            } else if (bmi_score > thresholds.over[1]) {
                                bmiStatus.val('Obesity');
                            } else {
                                bmiStatus.val('Unknown');
                            }
                        } else {
                            bmiStatus.val('Unknown');
                        }
                        console.log('BMI Score:', bmi_score);
                    } else {
                        bmi_score = 0;
                        bmiStatus.val('');
                    }
                });
            })