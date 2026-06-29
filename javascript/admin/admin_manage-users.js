$(document).ready(function () {
    var data = [
        { lastname: "Almeda", firstname: "Angelo Florence", idnum: "12413356", email: "angelo_florence_almeda@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Santos", firstname: "Miguel", idnum: "12310001", email: "miguel_santos@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Reyes", firstname: "Andrea", idnum: "12310002", email: "andrea_reyes@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Garcia", firstname: "John Paul", idnum: "12310003", email: "johnpaul_garcia@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Cruz", firstname: "Samantha", idnum: "12310004", email: "samantha_cruz@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Mendoza", firstname: "Joshua", idnum: "12310005", email: "joshua_mendoza@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Torres", firstname: "Nicole", idnum: "12310006", email: "nicole_torres@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Villanueva", firstname: "Mark", idnum: "12310007", email: "mark_villanueva@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Ramos", firstname: "Patricia", idnum: "12310008", email: "patricia_ramos@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Flores", firstname: "Kevin", idnum: "12310009", email: "kevin_flores@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Navarro", firstname: "Angela", idnum: "12310010", email: "angela_navarro@dlsu.edu.ph", userlevel: "Student" },
        { lastname: "Aquino", firstname: "Daniel", idnum: "12310011", email: "daniel_aquino@dlsu.edu.ph", userlevel: "Staff" },
        { lastname: "Lim", firstname: "Christine", idnum: "12310012", email: "christine_lim@dlsu.edu.ph", userlevel: "Staff" },
        { lastname: "Tan", firstname: "Jerome", idnum: "12310013", email: "jerome_tan@dlsu.edu.ph", userlevel: "Staff" },
        { lastname: "Co", firstname: "Melissa", idnum: "12310014", email: "melissa_co@dlsu.edu.ph", userlevel: "Staff" },
        { lastname: "Chua", firstname: "Vincent", idnum: "12310015", email: "vincent_chua@dlsu.edu.ph", userlevel: "Staff" },
        { lastname: "Lee", firstname: "Karen", idnum: "12310016", email: "karen_lee@dlsu.edu.ph", userlevel: "Admin" },
        { lastname: "Go", firstname: "Richard", idnum: "12310017", email: "richard_go@dlsu.edu.ph", userlevel: "Admin" },
        { lastname: "Ong", firstname: "Sophia", idnum: "12310018", email: "sophia_ong@dlsu.edu.ph", userlevel: "Admin" },
        { lastname: "Sy", firstname: "Matthew", idnum: "12310019", email: "matthew_sy@dlsu.edu.ph", userlevel: "Admin" }
    ];

    var table = $('#manageUsersTable').DataTable({
        data: data,
        columns: [
            { data: 'lastname' },
            { data: 'firstname' },
            { data: 'idnum' },
            { data: 'email' },
            { data: 'userlevel' },
            {
                data: null, // no actual data field, we're generating HTML
                orderable: false, // don't let users sort by this column
                searchable: false, // exclude from search bar matching
                render: function (data, type, row) {
                    return `
                        <button class="function-button edit-btn" data-id="${row.idnum}">Edit</button>
                        <button class="function-button delete-btn" data-id="${row.idnum}">Delete</button>
                    `;
                }
            }
        ],
        dom: 'lrtip'
    });

    // EDIT BUTTON CLICK
    $('#manageUsersTable tbody').on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        console.log('Edit user with ID:', id);
        // TODO: open edit modal, or redirect to an edit page, etc.
        alert('Edit Account');
    });

    // DELETE BUTTON CLICK
    $('#manageUsersTable tbody').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        console.log('Delete user with ID:', id);
        // TODO: confirm deletion, then call backend DELETE endpoint
        alert('Delete Account');
    });


    // map sortField values to actual column indices
    var columnMap = {
        firstname: 1,
        lastname: 0,
        idnum: 2,
        userlevel: 4
    };

    var currentDirection = 'asc'; // track current sort direction

    // SEARCH BAR
    $('.search-bar').on('keyup', function () {
        table.search(this.value).draw();
    });

    // SORT FIELD DROPDOWN
    $('#sortField').on('change', function () {
        applySort();
    });

    // SORT DIRECTION TOGGLE BUTTON
    $('#sortDirection').on('click', function () {
        currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
        $(this).text(currentDirection === 'asc' ? '↑' : '↓'); // update button label
        applySort();
    });

    function applySort() {
        var field = $('#sortField').val();
        var columnIndex = columnMap[field];
        table.order([columnIndex, currentDirection]).draw();
    }

    // FILTER DROPDOWN
    $('.filter-dropdown').on('change', function () {
        var value = $(this).val();
        if (value === 'Filter: All') {
            table.column(4).search('').draw();
        } else {
            table.column(4).search('^' + value + '$', true, false).draw();
        }
    });
});