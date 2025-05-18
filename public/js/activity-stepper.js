$(document).ready(function () {
    console.log('jQuery is working'); // Debugging message

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
        if (currentStep < totalSteps) {
            currentStep++; // Increase the current step
            showStep(currentStep); // Update the stepper
        }
    });

    // Initialize the first step
    showStep(currentStep);
});