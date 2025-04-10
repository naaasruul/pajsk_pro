$(() => {
    let selectedStudentLeaderId = null; // Store the selected student leader's ID
    let selectedStudentIds = []; // Array to store selected student IDs
    let selectedStudentNames = []; // Array to store selected student Names
    const studentRowsPerPage = 10; // Number of rows per page for students
    let studentCurrentPage = 1; // Current page for students

    // Handle "Assign Leader" button click for students
    $(document).on("click", ".assign-student-leader-btn", function () {
        const studentId = $(this).data("student-id");
        const row = $(this).closest("tr");

        if (selectedStudentLeaderId === studentId) {
            // Deassign the leader
            row.removeClass("bg-green-100 dark:bg-green-800");
            row.find('input[type="checkbox"]').prop("disabled", false);
            selectedStudentLeaderId = null;
            alert(`Student with ID ${studentId} is no longer the leader.`);
        } else {
            // Assign the leader
            $("tbody .student-tr").removeClass("bg-green-100 dark:bg-green-800");
            $("tbody .student-tr input[type='checkbox']").prop("disabled", false);

            row.addClass("bg-green-100 dark:bg-green-800");
            row.find('input[type="checkbox"]').prop("disabled", true);
            selectedStudentLeaderId = studentId;
            alert(`Student with ID ${studentId} is now the leader.`);
        }
    });

    // Handle row selection for students
    $(document).on("click", "tbody .student-tr", function () {
        const checkbox = $(this).find('input[type="checkbox"]');
        const studentId = checkbox.attr("id").split("-").pop(); // Extract student ID from checkbox ID

        if (checkbox.prop("disabled")) return; // Skip if the checkbox is disabled

        checkbox.prop("checked", !checkbox.prop("checked")); // Toggle checkbox state

        if (checkbox.prop("checked")) {
            // Add student ID to the selected list
            if (!selectedStudentIds.includes(studentId)) {
                selectedStudentIds.push(studentId);
            }
        } else {
            // Remove student ID from the selected list
            selectedStudentIds = selectedStudentIds.filter((id) => id !== studentId);
        }

        // Highlight the row if selected
        $(this).toggleClass(
            "bg-blue-100 dark:bg-blue-800",
            checkbox.prop("checked")
        );
    });

    // Handle "Select All" checkbox for students
    $("#checkbox-all-students").on("click", function () {
        const isChecked = $(this).prop("checked"); // Check if "Select All" is checked
        $("tbody .student-tr:visible input[type='checkbox']").each(function () {
            const studentId = $(this).attr("id").split("-").pop(); // Extract student ID

            if (!$(this).prop("disabled")) {
                $(this).prop("checked", isChecked); // Set checkbox state
                $(this).closest("tr").toggleClass("bg-blue-100 dark:bg-blue-800", isChecked); // Highlight row

                if (isChecked) {
                    // Add student ID to the selected list
                    if (!selectedStudentIds.includes(studentId)) {
                        selectedStudentIds.push(studentId);
                    }
                } else {
                    // Remove student ID from the selected list
                    selectedStudentIds = selectedStudentIds.filter((id) => id !== studentId);
                }
            }
        });
    });

    // Implement client-side pagination for students
    function paginateStudentTable() {
        const rows = $(".student-tr");
        const totalPages = Math.ceil(rows.length / studentRowsPerPage);

        // Hide all rows
        rows.hide();

        // Show rows for the current page
        const start = (studentCurrentPage - 1) * studentRowsPerPage;
        const end = start + studentRowsPerPage;
        rows.slice(start, end).show();

        // Update pagination buttons
        $("#pagination-buttons-student").html("");
        for (let i = 1; i <= totalPages; i++) {
            const button = $(`  <li>
                <a href="#" 
                class="flex items-center student-pagination-btn justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                ${i}
                </a>
                </li>`);
            if (i === studentCurrentPage) button.addClass("active");
            $("#pagination-buttons-student").append(button);
        }

        // Reapply selected rows
        reapplyStudentSelections();
    }

    // Handle pagination button click for students
    $(document).on("click", ".student-pagination-btn", function () {
        studentCurrentPage = parseInt($(this).text());
        paginateStudentTable();
    });

    // Reapply selected rows after pagination for students
    function reapplyStudentSelections() {
        selectedStudentIds.forEach((studentId) => {
            const checkbox = $(`#checkbox-student-${studentId}`);
            checkbox.prop("checked", true); // Check the checkbox
            checkbox.closest("tr").addClass("bg-blue-100 dark:bg-blue-800"); // Highlight the row
        });

        if (selectedStudentLeaderId) {
            const leaderRow = $(`#checkbox-student-${selectedStudentLeaderId}`).closest("tr");
            leaderRow.addClass("bg-green-100 dark:bg-green-800");
            leaderRow.find('input[type="checkbox"]').prop("disabled", true);
        }
    }

    // Initial pagination for students
    paginateStudentTable();

    // Prevent checkbox click from triggering row click for students
    $(document).on("click", 'input[type="checkbox"]', function (e) {
        e.stopPropagation();
    });

    // Handle student search
    $("#student-search").on("input", function () {
        const query = $(this).val().toLowerCase();
        console.log("Search Query: ", query);
        // Filter the student list based on the search query
        $("tbody .student-tr").each(function () {
            const studentName = $(this).find("th").text().toLowerCase();
            const studentEmail = $(this).find("td").eq(1).text().toLowerCase();

            if (studentName.includes(query) || studentEmail.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // // Reset pagination after search
        // studentCurrentPage = 1;
        // paginateStudentTable();
    });
});