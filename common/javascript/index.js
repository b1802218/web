const images = ["../photo/bread2.jpeg","../photo/bread1.jpeg","../photo/bread3.jpeg"];

let count = 0;
const slideimage =()=>{
    if(getElementById('next').onclick){
        count++;
        document.getElementById('slideshow').src = images[count];
    }
    else if(getElementById('back')){
        count--;
        document.getElementById('slideshow').src = images[count];
    }
}



const weeks = ['日', '月', '火', '水', '木', '金', '土'];
const date = new Date();
const year = date.getFullYear();
const month = date.getMonth() + 1;
const startDate = new Date(year, month - 1, 1); 
const endDate = new Date(year, month,  0);
const endDayCount = endDate.getDate();
const startDay = startDate.getDay();
let dayCount = 1;
let calendarHtml = '';

calendarHtml += '<h1>' + year  + '/' + month + '</h1>';
calendarHtml += '<table>';

for (let i = 0; i < weeks.length; i++) {
    calendarHtml += '<td>' + weeks[i] + '</td>':
}

for (let w = 0; w < 6; w++) {
    calendarHtml += '<tr>':

    for (let d = 0; d < 7; d++) {
        if (w == 0 && d < startDay) {

            calendarHtml += '<td></td>';
        } else if (dayCount > endDayCount) {

            calendarHtml += '<td></td>';
        } else {
            calendarHtml += '<td>' + dayCount + '</td>';
            dayCount++;
        }
    }
    calendarHtml += '</tr>';
}
calendarHtml += '</table>';

document.querySelector('#calendar').innerHTML = calendarHtml;