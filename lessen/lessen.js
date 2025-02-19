function showTimes(date) {
    document.getElementById('selected-date').innerText = 'Tijdslots voor ' + date;
    document.getElementById('date-input').value = date;
    document.getElementById('modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
