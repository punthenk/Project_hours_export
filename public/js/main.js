document.addEventListener("DOMContentLoaded", () => {
    const taskModal = document.getElementById("taskModal");
    const taskOpenBtn = document.getElementById("openTaskModal");
    const taskCancelBtn = document.getElementById("cancelTaskModal");

    console.log(taskModal);
    console.log(taskOpenBtn);
    console.log(taskCancelBtn);

    if (!taskModal || !taskOpenBtn || !taskCancelBtn) return;

    taskOpenBtn.addEventListener("click", () => {
        console.log("HELLO");
        taskModal.classList.remove("hidden");
    });

    taskCancelBtn.addEventListener("click", () => {
        taskModal.classList.add("hidden");
    });

    // Close taskModal when clicking outside of it
    taskModal.addEventListener("click", (e) => {
        if (e.target === taskModal) {
            taskModal.classList.add("hidden");
        }
    });

});



document.addEventListener("DOMContentLoaded", () => {

    // Modal toggle
    const modal = document.getElementById('new-project-modal');
    const openBtn = document.getElementById('new-project-btn');
    const cancelBtn = document.getElementById('modal-cancel');

    if (!openBtn || !modal || !cancelBtn) return;

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Close modal when clicking outside the content
    modal.addEventListener('click', (e) => {
        if(e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
