document.addEventListener("DOMContentLoaded", () => {

    // Modal toggle
    const modal = document.getElementById('update-task-modal');
    const openBtn = document.querySelectorAll('.change-task-button');
    const cancelBtn = document.getElementById('cancel-update-task-modal');
    const form = document.getElementById('update-task-form');

    if (!openBtn || !modal || !cancelBtn) return;

    openBtn.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');

            form.action = `/task/${button.dataset.id}/update`;
            form.method = "POST";
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "PUT";
            form.appendChild(methodInput);

            form.querySelector("input[name='name']").value = button.dataset.name;
            form.querySelector("textarea[name='description']").value = button.dataset.description;
            // form.querySelector("input[name='worked_time']").value = button.dataset.worked_time || "";

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

