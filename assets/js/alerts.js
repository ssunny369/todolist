/**
 * GLOBAL FUNCTIONS
 * These are called directly from PHP using onclick="functionName(id)"
 */

// 1. Dashboard: Toggle Done/Undo
window.confirmToggle = function(id, isDone) {
    const title = isDone ? "Mark as pending?" : "Mark as completed?";
    const icon = isDone ? "question" : "success";

    Swal.fire({
        title: title,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, do it!',
        timer: 3000,
        timerProgressBar: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('toggle-form-' + id);
            if(form) form.submit();
        }
    });
}

// 2. Dashboard: Delete Task
window.confirmDelete = function(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This task will be removed forever!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form-' + id);
            if(form) form.submit();
        }
    });
}

// 3. New: Logout Confirmation
window.confirmLogout = function(logoutUrl) {
    Swal.fire({
        title: 'Logout?',
        text: "Are you sure you want to end your session?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Logout'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = logoutUrl;
        }
    });
}

// 4. Real-time Clock logic
function updateTime() {
    const clockElement = document.getElementById('real-time-clock');
    if (clockElement) {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        clockElement.textContent = now.toLocaleTimeString(undefined, options);
    }
}
updateTime();
setInterval(updateTime, 1000);

/**
 * EVENT LISTENERS
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // User List: Delete User
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            const name = this.getAttribute('data-name') || "this user";

            Swal.fire({
                title: "Delete User?",
                text: "Permanently delete " + name + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete"
            }).then((result) => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });

    // User List: Edit/Update User
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            const name = this.getAttribute('data-name') || "this user";

            Swal.fire({
                title: "Edit Details?",
                text: "Modify information for " + name + "?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, edit"
            }).then((result) => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });
});

/**
 * 5. TOAST NOTIFICATIONS (Success/Error)
 * Use this to show quick messages that disappear
 */
window.showToast = function(message, type = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: type,
        title: message
    });
}