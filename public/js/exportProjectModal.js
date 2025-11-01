document.addEventListener("DOMContentLoaded", () => {

    // Modal toggle
    const modal = document.getElementById('export-project-modal');
    const openBtn = document.querySelectorAll('.export-modal-btn');
    const cancelBtn = document.getElementById('cancel-export-project-modal');
    const form = document.getElementById('export-project-form');

    if (!openBtn || !modal || !cancelBtn) return;

    openBtn.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
            projectId = button.dataset.project_id;

            form.action = `project/${projectId}/export`;
        });
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

