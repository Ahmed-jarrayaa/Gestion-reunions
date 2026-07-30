<?php
$this->assign('title', 'Calendrier des réunions');
?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<style>
  #calendrier-container {
    max-width: 900px;
    margin: 10px auto;
    padding: 10px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  }
  #clock {
    font-size: 20px;
    font-weight: 700;
    text-align: right;
    margin: 10px auto 0;
    max-width: 1100px;
  }
</style>

<!-- Horloge -->
<div id="clock"></div>

<!-- Calendrier -->
<div id="calendrier-container">
  <div id="calendar"></div>
</div>
<div class="calendrier-container">
    <div class="Calendrier">
        <!-- Ici ton code du calendrier (ex : FullCalendar ou ton tableau) -->
        <div id="calendar"></div>
    </div>
</div>


<script>
// ---------------- HORLOGE ----------------
function updateClock() {
  const now = new Date();
  const opts = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
  document.getElementById('clock').innerText =
    now.toLocaleDateString('fr-FR') + ' ' + now.toLocaleTimeString('fr-FR', opts);
}
setInterval(updateClock, 1000);
updateClock();

// ---------------- FULLCALENDAR -----------
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'fr',
    firstDay: 1,
    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    events: '<?= $this->Url->build('/reunions/events') ?>',
    navLinks: true,
    nowIndicator: true,
    eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: false },
    eventDidMount: function(info) {
      // Affiche titre + heure
      var start = new Date(info.event.start);
      info.el.title = info.event.title + ' - ' + start.toLocaleString('fr-FR');
    }
  });

  calendar.render();
});
</script>
