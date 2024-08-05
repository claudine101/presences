SELECT
|           WHERE DATE_FORMAT(`DATE_PRESENCE`, '%m') = DATE_FORMAT(presences.`DATE_PRESENCE`, '%m')
       )
    ) AS absences,
    SUM(CASE WHEN (`STATUT`) = 1 THEN 1 ELSE 0 END) AS number_of_punctuals,
    SUM(CASE WHEN (`STATUT`) = 0 THEN 1 ELSE 0 END) AS number_of_lates
FROM
    presences
JOIN employes ON employes.ID_UTILISATEUR = presences.ID_UTILISATEUR
JOIN agences ON agences.ID_AGENCE = employes.ID_AGENCE
WHERE
    presences.ID_UTILISATEUR =2
GROUP BY
    MONTH(`DATE_PRESENCE`)
ORDER BY
    MONTH(`DATE_PRESENCE`);




    WITH RECURSIVE calendar AS (
    SELECT CURDATE() - INTERVAL 1 MONTH AS date
    UNION ALL
    SELECT date + INTERVAL 1 DAY
    FROM calendar
    WHERE date + INTERVAL 1 DAY <= CURDATE()
)

SELECT COUNT(date) AS absences
FROM (
    SELECT date
    FROM calendar
    WHERE DAYOFWEEK(date) NOT IN (1, 7) -- Exclure les samedis (7) et dimanches (1)
) AS working_days
WHERE date NOT IN (
    SELECT DATE(DATE_PRESENCE)
    FROM presences
    WHERE ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."
);