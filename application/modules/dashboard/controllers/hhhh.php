SELECT
    MONTHNAME(`DATE_PRESENCE`) AS month_name,
    COUNT(`ID_PRESENCE`) AS total_presence,
    DATE_FORMAT(`DATE_PRESENCE`, '%m') AS month,
    (SELECT COUNT(`ID_UTILISATEUR`) 
     FROM employes 
     WHERE ID_AGENCE = employes.ID_AGENCE
       AND ID_UTILISATEUR NOT IN (
           SELECT ID_UTILISATEUR 
           FROM presences 
           WHERE DATE_FORMAT(`DATE_PRESENCE`, '%m') = DATE_FORMAT(presences.`DATE_PRESENCE`, '%m')
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
