$(document).ready(function () {
    console.log('jQuery is working'); // Debugging message

          // Function to show error messages
          function showError(input, message) {
              console.log(input.parent()); // Debugging message
              // Check if the error message already exists
              if (!input.parent().next("p.text-red-600").length) {
                  const errorElement = $(
                      `<p class="mt-2 text-sm text-red-600 dark:text-red-500">${message}</p>`
                  );

                  // Remove conflicting border classes
                  input.removeClass("border-gray-300 dark:border-gray-600");

                  // Add the red border class
                  input.addClass("border-red-500 dark:border-red-500");

                  input.parent().after(errorElement); // Add the error message after the input

                //   // Automatically remove the error message and red border after 2 seconds
                //   setTimeout(() => {
                //       removeError(input);
                //   }, 2000); // Adjusted to 2 seconds
              }
          }

        

        // Function to remove error messages
        function removeError(input) {
            input.removeClass('border-red-500 dark:border-red-500'); 
            input.addClass('border-gray-300 dark:border-gray-600'); // Remove the red border

            input.parent().next('p.text-red-600 ').remove(); // Remove the error message
        }


         // Validate individual fields on blur
         $('#date-start').on('blur', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'Start date is required.');
            } else {
                removeError($(this));
            }
        });

        $('#date-end').on('blur', function () {
            const startDate = new Date($('#date-start').val());
            const endDate = new Date($(this).val());
            if (!$(this).val()) {
                showError($(this), 'End date is required.');
            } else if (endDate < startDate) {
                showError($(this), 'End date cannot be earlier than the start date.');
            } else {
                removeError($(this));
            }
        });
        $('#address').on('blur', function () {
            console.log('Address field blurred'); // Debugging message
            const address = $(this).val().trim(); // Get the value and trim whitespace
            if (!address) {
                showError($(this), 'Address is required.'); // Show error if empty
            } else {
                removeError($(this)); // Remove error if valid
            }
        });

        $('#time-start').on('blur', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'Start time is required.');
            } else {
                removeError($(this));
            }
        });

        $('#time-end').on('blur', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'End time is required.');
            } else {
                removeError($(this));
            }
        });

        $('#involvement').on('change', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'Involvement type is required.');
            } else {
                removeError($(this));
            }
        });

        $('#club').on('change', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'Club selection is required.');
            } else {
                removeError($(this));
            }
        });

        $('#achievement').on('change', function () {
            const value = $(this).val();
            if (!value) {
                showError($(this), 'Achievement stage is required.');
            } else {
                removeError($(this));
            }
        });

    let currentStep = 1; // Start at step 1
    const totalSteps = $('.step').length; // Total number of steps

    // Function to show the current step
    function showStep(step) {
        console.log(`Showing step ${step}`); // Debugging message

        // Update the active step in the stepper
        $('.step').removeClass('active text-blue-600 dark:text-blue-500'); // Remove active class from all steps
        $('.step').addClass('text-gray-500 dark:text-gray-400'); // Reset inactive class
        $(`.step[data-step="${step}"]`).addClass('active text-blue-600 dark:text-blue-500'); // Add active class to the current step
        $(`.step[data-step="${step}"]`).removeClass('text-gray-500 dark:text-gray-400'); // Remove inactive class

        // Show the current step content and hide others
        $('.step-content').addClass('hidden'); // Hide all step contents
        $(`.step-content[data-step="${step}"]`).removeClass('hidden'); // Show the current step content

        // Toggle button visibility
        $('#prev-button').toggleClass('hidden', step === 1); // Hide "Previous" button on the first step
        $('#next-button').toggleClass('hidden', step === totalSteps); // Hide "Next" button on the last step
        $('#submit-button').toggleClass('hidden', step !== totalSteps); // Show "Submit" button only on the last step
    }

    // Event listener for the "Previous" button
    $('#prev-button').click(function (e) {
        console.log('Previous button clicked'); // Debugging message
        e.preventDefault();
        if (currentStep > 1) {
            currentStep--; // Decrease the current step
            showStep(currentStep); // Update the stepper
        }
    });

    // Event listener for the "Next" button
    $('#next-button').click(function (e) {
        console.log('Next button clicked'); // Debugging message
        e.preventDefault();
        let isValid = true;

        // Validate all required fields
        $('#date-start, #date-end, #time-start, #time-end, #involvement, #club, #achievement, #address').each(function () {
            if (!$(this).val()) {
                showError($(this), 'This field is required.');
                isValid = false;
            } else {
                removeError($(this));
                
            }
        });

        // Prevent moving to the next step if validation fails
        if (!isValid) {
            alert('Please fix the errors before proceeding.');
            return false;
        }else{
            if (currentStep < totalSteps) {
                currentStep++; // Increase the current step
                showStep(currentStep); // Update the stepper
            }
        }
       
    });

    // Initialize the first step
    showStep(currentStep);
});