document.addEventListener("DOMContentLoaded", () => {

    // Modal toggle
    const modal = document.getElementById('update-session-modal');
    const openBtn = document.querySelectorAll('.change-session-button');
    const cancelBtn = document.getElementById('cancel-update-session-modal');
    const form = document.getElementById('update-session-form');

    if (!openBtn || !modal || !cancelBtn) return;

    openBtn.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');

            form.action = `/session/${button.dataset.id}/update`;

            form.querySelector("input[name='started_at']").value = button.dataset.started_at;
            form.querySelector("input[name='stopped_at']").value = button.dataset.stopped_at;
            form.querySelector("input[name='created_at']").value = button.dataset.session_date;
            form.querySelector("input[name='task_id']").value = button.dataset.task_id;
        });
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Close modal when clicking outside the content
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

