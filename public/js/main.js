
// Modal toggle
const modal = document.getElementById('new-project-modal');
const openBtn = document.getElementById('new-project-btn');
const cancelBtn = document.getElementById('modal-cancel');

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


document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("taskModal");
    const openBtn = document.getElementById("openTaskModal");
    const cancelBtn = document.getElementById("cancelTaskModal");

    if (!modal || !openBtn || !cancelBtn) return;

    openBtn.addEventListener("click", () => {
        modal.classList.remove("hidden");
    });

    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Close modal when clicking outside of it
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});
