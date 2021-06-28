$(function () {
    $('input[name="daterange"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
    }, function (start, end, label) {
        let date_debut = start.format('DD/MM/YYYY HH:mm');
        let date_fin = end.format('DD/MM/YYYY HH:mm');
        $('#date-debut').val(date_debut);
        $('#date-fin').val(date_fin);
        let duration = getDuration(start, end)
        $('#duree_mission').val(duration[1]);
        $('#decompte_or').val(duration[2]);
    });
});

/**
 * function durationAsString
 * @param start
 * @param end
 * @returns {string}
 */
function getDuration(start, end) {
    let response = []
    const duration = moment.duration(moment(end).diff(moment(start)));
    //Get Days
    const days = Math.floor(duration.asDays());
    const daysFormatted = days ? `${days}j ` : '';
    //Get Hours
    const hours = duration.hours();
    const hoursFormatted = `${hours}h `;
    let partial = '';
    let normal = '';
    let montant_p = '';
    let montant_n = '';
    if (hours > 8) {
        partial = ' et ' + parseInt(hours / 8) + 'P';
        montant_p = parseFloat(parseInt(hours / 8) * 10000)
    }
    if (days) {
        normal = days + 'N';
        montant_n = parseFloat(days * 30000)
    }
    //Get Minutes
    const minutes = duration.minutes();
    const minutesFormatted = `${minutes}m`;
    response = [
        [daysFormatted, hoursFormatted, minutesFormatted].join(''),
        normal + partial,
        montant_p + montant_n
    ]
    return response;
}
