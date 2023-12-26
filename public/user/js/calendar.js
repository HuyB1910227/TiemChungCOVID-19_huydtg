const date = new Date()
const nextBtn = document.querySelector(".next")
const prevBtn = document.querySelector(".prev")
function renderCalendar(){
    date.setDate(1);
    const daysOfTheMonth = document.querySelector(".days");
    const lastDay = new Date(date.getFullYear(), date.getMonth()+1, 0).getDate()
    const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate()
    const firstDayIndex = date.getDay();
    const lastDayIndex = new Date(date.getFullYear(), date.getMonth()+1, 0).getDay()
    const nextDays = 7 - lastDayIndex - 1;
    const months = [
        "Tháng 1",
        "Tháng 2",
        "Tháng 3",
        "Tháng 4",
        "Tháng 5",
        "Tháng 6",
        "Tháng 7",
        "Tháng 8",
        "Tháng 9",
        "Tháng 10",
        "Tháng 11",
        "Tháng 12",
    ];
    document.querySelector(".date h1").innerHTML = months[date.getMonth()];
    document.querySelector(".date p").innerHTML = "Năm " + date.getFullYear();
    let days = "";
    for (let x = firstDayIndex; x > 0; x--) {
        days += `<div class="prev-date">${prevLastDay - x + 1}</div>`;
    }
    for (let i = 1; i <= lastDay; i++) {
        if (
            i === new Date().getDate() &&
            date.getMonth() === new Date().getMonth()
        ) {
            days += `<div class="today">${i}</div>`;
        } else {
            days += `<div>${i}</div>`;
        }
    }
    for (let j = 1; j <= nextDays; j++) {
        days += `<div class="next-date">${j}</div>`;
    }
    daysOfTheMonth.innerHTML = days;
};
prevBtn.addEventListener("click", function(){
    date.setMonth(date.getMonth() - 1)
    renderCalendar()
})
nextBtn.addEventListener("click", function(){
    date.setMonth(date.getMonth() + 1)
    renderCalendar()
})
renderCalendar();