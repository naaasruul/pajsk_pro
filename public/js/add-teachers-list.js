$(() => {
    let selectedLeaderId = null; // Store the selected leader's ID
    window.selectedLeaderId = selectedLeaderId; // Expose globally

    let selectedTeacherIds = []; // Array to store selected teacher IDs
    let selectedTeacherNames = []; // Array to store selected teacher Names
    const rowsPerPage = 10; // Number of rows per page
    let currentPage = 1; // Current page

    // Handle "Assign Leader" button click
    $(document).on("click", ".assign-leader-btn", function () {
        const teacherId = $(this).data("teacher-id");
        const row = $(this).closest("tr");

        if (window.selectedLeaderId === teacherId) {
            // Deassign the leader
            row.removeClass("bg-green-100 dark:bg-green-800");
            row.find('input[type="checkbox"]').prop("disabled", false);
            window.selectedLeaderId = null;
            alert(`Teacher with ID ${teacherId} is no longer the leader.`);
        } else {
            // Assign the leader
            $("tbody tr").removeClass("bg-green-100 dark:bg-green-800");
            $("tbody tr input[type='checkbox']").prop("disabled", false);

            row.addClass("bg-green-100 dark:bg-green-800");
            row.find('input[type="checkbox"]').prop("disabled", true);
            window.selectedLeaderId = teacherId;
            alert(`Teacher with ID ${teacherId} is now the leader.`);
        }
    });

    // Handle row selection
    $(document).on("click", "tbody tr", function () {
        const checkbox = $(this).find('input[type="checkbox"]');
        const teacherId = checkbox.attr("id").split("-").pop(); // Extract teacher ID from checkbox ID

        if (checkbox.prop("disabled")) return; // Skip if the checkbox is disabled

        checkbox.prop("checked", !checkbox.prop("checked")); // Toggle checkbox state

        if (checkbox.prop("checked")) {
            // Add teacher ID to the selected list
            if (!selectedTeacherIds.includes(teacherId)) {
                selectedTeacherIds.push(teacherId);
            }
        } else {
            // Remove teacher ID from the selected list
            selectedTeacherIds = selectedTeacherIds.filter((id) => id !== teacherId);
        }

        // Highlight the row if selected
        $(this).toggleClass(
            "bg-blue-100 dark:bg-blue-800",
            checkbox.prop("checked")
        );
    });

    // Handle "Select All" checkbox
    $("#checkbox-all-search").on("click", function () {
        const isChecked = $(this).prop("checked"); // Check if "Select All" is checked
        $("tbody tr:visible input[type='checkbox']").each(function () {
            const teacherId = $(this).attr("id").split("-").pop(); // Extract teacher ID

            if (!$(this).prop("disabled")) {
                $(this).prop("checked", isChecked); // Set checkbox state
                $(this).closest("tr").toggleClass("bg-blue-100 dark:bg-blue-800", isChecked); // Highlight row

                if (isChecked) {
                    // Add teacher ID to the selected list
                    if (!selectedTeacherIds.includes(teacherId)) {
                        selectedTeacherIds.push(teacherId);
                    }
                } else {
                    // Remove teacher ID from the selected list
                    selectedTeacherIds = selectedTeacherIds.filter((id) => id !== teacherId);
                }
            }
        });
    });

    // Implement client-side pagination
    function paginateTable() {
        const rows = $(".teacher-tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        console.log("Total Pages: ", totalPages);
        console.log("Current Page: ", currentPage);
        // Hide all rows
        rows.hide();

        // Show rows for the current page
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).show();

        // Update pagination buttons
        $("#pagination-buttons-teacher").html("");
        for (let i = 1; i <= totalPages; i++) {
            const button = $(
                `
                <li>
                <a href="#" 
                class="flex items-center pagination-btn justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                ${i}
                </a>
                </li>
`
            );
            if (i === currentPage) button.addClass("active");
            $("#pagination-buttons-teacher").append(button);
        }

        // Reapply selected rows
        reapplySelections();
    }

    // Handle pagination button click
    $(document).on("click", ".pagination-btn", function () {
        currentPage = parseInt($(this).text());
        paginateTable();
    });

    // Reapply selected rows after pagination
    function reapplySelections() {
        selectedTeacherIds.forEach((teacherId) => {
            const checkbox = $(`#checkbox-table-search-${teacherId}`);
            checkbox.prop("checked", true); // Check the checkbox
            checkbox.closest("tr").addClass("bg-blue-100 dark:bg-blue-800"); // Highlight the row
        });

        if (selectedLeaderId) {
            const leaderRow = $(`#checkbox-table-search-${selectedLeaderId}`).closest("tr");
            leaderRow.addClass("bg-green-100 dark:bg-green-800");
            leaderRow.find('input[type="checkbox"]').prop("disabled", true);
        }
    }

    // Initial pagination
    paginateTable();

    // Prevent checkbox click from triggering row click
    $(document).on("click", 'input[type="checkbox"]', function (e) {
        e.stopPropagation();
    });

    // Handle teacher search
    $("#teacher-search").on("input", function (e) {
        e.preventDefault();
        const query = $(this).val().toLowerCase();

        // Filter the teacher list based on the search query
        $("tbody .teacher-tr").each(function () {
            const teacherName = $(this).find("th").text().toLowerCase();
            const teacherEmail = $(this).find("td").eq(1).text().toLowerCase();

            if (teacherName.includes(query) || teacherEmail.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // // Reset pagination after search
        // currentPage = 1;
        // paginateTable();
    });
});