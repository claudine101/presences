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




    -- Créer une table temporaire pour générer la liste des dates
CREATE TEMPORARY TABLE temp_dates (date DATE);

-- Insérer les dates des 30 derniers jours (ajustez la période si nécessaire)
INSERT INTO temp_dates
SELECT CURDATE() - INTERVAL seq DAY
FROM (SELECT @rownum := @rownum + 1 AS seq FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a, (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b, (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c, (SELECT @rownum := -1) r) d
WHERE CURDATE() - INTERVAL seq DAY >= CURDATE() - INTERVAL 1 MONTH;

-- Exclure les samedis et dimanches
DELETE FROM temp_dates WHERE DAYOFWEEK(date) IN (1, 7);

-- Calculer les absences
SELECT COUNT(date) AS absences
FROM temp_dates
WHERE date NOT IN (
    SELECT DATE(DATE_PRESENCE)
    FROM presences
    WHERE ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."
);

-- Supprimer la table temporaire après usage
DROP TEMPORARY TABLE temp_dates;
