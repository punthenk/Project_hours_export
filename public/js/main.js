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

    const started = document.getElementById('started_at');
    const stopped = document.getElementById('stopped_at');
    const btn = document.getElementById('add-session-btn');

    if (!started || !stopped || !btn) return;

    [started, stopped].forEach(input => {
        input.addEventListener('input', () => {
            btn.disabled = !(started.value && stopped.value);
        });
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
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

document.querySelectorAll('.task-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', async e => {
        const id = e.target.dataset.id;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const response = await fetch(`/task/${id}/toggle`, {
           method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: '{}'
        });
        if (!response.ok) alert('Update failed');
        const data = await response.json();
        const nameEl = e.target.closest('.flex').querySelector('p');
        nameEl.classList.toggle('line-through', data.completed);
        nameEl.classList.toggle('text-gray-500', data.completed);
        nameEl.classList.toggle('text-gray-800', !data.completed);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.getElementById('filterButton');
    const taskItems = document.querySelectorAll('.task-item');

    // Filter states: 'all', 'completed', 'uncompleted'
    let currentFilter = 'all';

    if (!filterButton || !taskItems) return;

    filterButton.addEventListener('click', function() {
        // Cycle through filters
        if (currentFilter === 'all') {
            currentFilter = 'completed';
            filterButton.textContent = 'Only Completed';
            filterButton.classList.add('bg-blue-100');
        } else if (currentFilter === 'completed') {
            currentFilter = 'uncompleted';
            filterButton.textContent = 'Only Uncompleted';
        } else {
            currentFilter = 'all';
            filterButton.textContent = 'All Tasks';
            filterButton.classList.remove('bg-blue-100');
        }

        // Apply filter
        taskItems.forEach(task => {
            const isCompleted = task.dataset.completed === 'true';

            if (currentFilter === 'all') {
                task.style.display = 'flex';
            } else if (currentFilter === 'completed' && isCompleted) {
                task.style.display = 'flex';
            } else if (currentFilter === 'uncompleted' && !isCompleted) {
                task.style.display = 'flex';
            } else {
                task.style.display = 'none';
            }
        });
    });
});
