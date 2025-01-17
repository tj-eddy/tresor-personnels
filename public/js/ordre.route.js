$(function () {
    $('#ordre_route_dateDebutMission,#ordre_route_dateFinMission,#ordre_route_indice').on('change', function () {
        let start = moment($('#ordre_route_dateDebutMission').val())
        let end = moment($('#ordre_route_dateFinMission').val())
        let duration = getDuration(start, end);
        $('#duree_mission').val(duration[1]);
        $('#decompte_or').val(duration[2]);
        $('#montant_p').val(duration[3]);
        $('#montant_n').val(duration[4]);
    })
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
    let val_indice = $('#ordre_route_indice').val();

    if (days) {
        if (val_indice < 800) {
            normal = days + 'N';
            montant_n = parseFloat(days * 30000)
        } else {
            normal = days + 'N';
            montant_n = parseFloat(days * 36000)
        }
    }

    if (hours > 8) {
        if (val_indice < 800) {
            partial = days ? ' et ' + parseInt(hours / 8) + 'P' : parseInt(hours / 8) + 'P';
            montant_p = parseFloat(parseInt(hours / 8) * 10000)
        } else {
            partial = days ? ' et ' + parseInt(hours / 8) + 'P' : parseInt(hours / 8) + 'P';
            montant_p = parseFloat(parseInt(hours / 8) * 12000)
        }
    }
    //Get Minutes
    const minutes = duration.minutes();
    const minutesFormatted = `${minutes}m`;
    response = [
        [daysFormatted, hoursFormatted, minutesFormatted].join(''),
        normal + partial,
        montant_p + montant_n,
        montant_p,
        montant_n
    ]

    return response;
}
