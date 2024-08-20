SET GLOBAL event_scheduler=ON;
SHOW VARIABLES LIKE 'event_scheduler';


BEGIN
    -- Vérification du jour de la semaine et insertion des absences
    IF DAYOFWEEK(CURDATE()) NOT IN (1, 7) THEN
        INSERT INTO absences (id_utilisateur, date_absence, heure_absence, periode, raison)
        SELECT u.ID_UTILISATEUR, CURDATE(), CURTIME(), 'AM', 'Absent à 12h'
        FROM Utilisateurs u
        LEFT JOIN Presences p ON u.ID_UTILISATEUR = p.ID_UTILISATEUR 
            AND DATE(p.DATE_PRESENCE) = CURDATE() 
            AND TIME(p.DATE_PRESENCE) BETWEEN '06:00:00' AND '11:59:59'
        LEFT JOIN Conges c ON u.ID_UTILISATEUR = c.ID_UTILISATEUR 
            AND c.DATE_CONGE = CURDATE() 
            AND c.periode = 'AM'
        WHERE p.ID_UTILISATEUR IS NULL 
            AND c.ID_UTILISATEUR IS NULL;
    END IF;
END

BEGIN
    -- Vérification du jour de la semaine et insertion des absences pour la période PM
    IF DAYOFWEEK(CURDATE()) NOT IN (1, 7) THEN
        INSERT INTO absences (id_utilisateur, date_absence, heure_absence, periode, raison)
        SELECT u.ID_UTILISATEUR, CURDATE(), CURTIME(), 'PM', 'Absent à 19h'
        FROM Utilisateurs u
        LEFT JOIN Presences p ON u.ID_UTILISATEUR = p.ID_UTILISATEUR 
            AND DATE(p.DATE_PRESENCE) = CURDATE() 
            AND TIME(p.DATE_PRESENCE) BETWEEN '12:00:00' AND '19:00:00'
        LEFT JOIN Conges c ON u.ID_UTILISATEUR = c.ID_UTILISATEUR 
            AND c.DATE_CONGE = CURDATE() 
            AND c.periode = 'PM'
        WHERE p.ID_UTILISATEUR IS NULL 
            AND c.ID_UTILISATEUR IS NULL;
    END IF;
END