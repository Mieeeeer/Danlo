const monthYear = document.getElementById('calendar-month-year');
const calendarDates = document.getElementById('calendar-dates');
const eventList = document.getElementById('event-list');

let currentDate = new Date();
let selectedDate = null;

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDate = new Date(year, month + 1, 0).getDate();
    const startDay = firstDay.getDay();

    monthYear.textContent = `${firstDay.toLocaleString('default', { month: 'long' })} ${year}`;
    calendarDates.innerHTML = '';

    // Add empty divs for days before the 1st of month
    for (let i = 0; i < startDay; i++) {
        const empty = document.createElement('div');
        calendarDates.appendChild(empty);
    }

for (let day = 1; day <= lastDate; day++) {
    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const cell = document.createElement('div');
    cell.textContent = day;

    const today = new Date();
    const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

    if (dateStr === todayStr) {
        cell.classList.add('today');
    }

    if (events[dateStr]) {
        cell.classList.add('has-event');
    }

    cell.addEventListener('click', () => {
        selectedDate = dateStr;
        displayEvents(dateStr);
    });

    calendarDates.appendChild(cell);
}

}

function displayEvents(dateStr) {
    eventList.innerHTML = '';
    if (events[dateStr]) {
        events[dateStr].forEach(e => {
            const li = document.createElement('li');
            li.textContent = e;
            eventList.appendChild(li);
        });
    } else {
        const li = document.createElement('li');
        li.textContent = 'No events for this day.';
        eventList.appendChild(li);
    }
}

document.getElementById('prev-month').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById('next-month').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();
