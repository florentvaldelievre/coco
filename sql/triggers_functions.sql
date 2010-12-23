SET GLOBAL log_bin_trust_function_creators = 1;

--
-- Function: getdtrfromtransport
--

delimiter //
CREATE FUNCTION `getdtrfromtransport` (idtransport_ INT) RETURNS int(11)    COMMENT ''
BEGIN
	DECLARE res INT;

    SELECT iddemandetr INTO res FROM transport WHERE idtransport = idtransport_;
	RETURN res;

END;//
delimiter ;
-- GO

--
-- Function: gettypeutilisateur
--

delimiter //
CREATE FUNCTION `gettypeutilisateur` (idutilisateurweb INT) RETURNS varchar(40) CHARSET latin1    COMMENT ''
BEGIN
	DECLARE res VARCHAR(40);

    SELECT typeutilisateur INTO res FROM utilisateur WHERE idutilisateur = idutilisateurweb;
	RETURN res;

END;//
delimiter ;
-- GO

--
-- Function: verifclient
--

delimiter //
CREATE FUNCTION `verifclient` (idutilisateur1web INT, iddemandetrweb INT) RETURNS tinyint(1)    COMMENT ''
BEGIN
	DECLARE res BOOLEAN DEFAULT FALSE;
    DECLARE idutilisateur1 INT(10);
    DECLARE valid INT(10);
    
    SELECT d.idutilisateur INTO idutilisateur1 FROM demandetr d JOIN reponsetr r ON d.iddemandetr=r.iddemandetr WHERE d.iddemandetr = iddemandetrweb AND rtag = 'valider';
	
	IF(idutilisateur1 = idutilisateur1web) THEN 
	SET res = TRUE;
	ELSE
	SET res = FALSE;
	END IF;
	RETURN res;
END;//
delimiter ;
-- GO

--
-- Function: veriftransport
--

delimiter //
CREATE FUNCTION `veriftransport` (idutilisateur1web INT, iddemandetrweb INT) RETURNS tinyint(1)    COMMENT ''
BEGIN
	DECLARE res BOOLEAN DEFAULT FALSE;
    DECLARE idutilisateur1 INT(10);
    DECLARE valid INT(10);
    
  	SELECT r.idutilisateur INTO idutilisateur1 FROM reponsetr r WHERE r.iddemandetr = iddemandetrweb AND rtag = 'valider';
	
	IF(idutilisateur1 = idutilisateur1web) THEN 
	SET res = TRUE;
	ELSE
	SET res = FALSE;
	END IF;
	RETURN res;
END;//
delimiter ;
-- GO


--
-- Triggers
--

delimiter //
CREATE TRIGGER `quotation_bi` BEFORE INSERT ON `quotation`
FOR EACH ROW
BEGIN
	
	
	-- verif que l'utilisateur est bien celui qui a fait la demande

		-- castransporteur
		IF gettypeutilisateur(new.idutilisateur1) = 'transporteur' THEN
			IF !(veriftransport(new.idutilisateur1, getdtrfromtransport(new.idtransport)) AND verifclient(new.idutilisateur2, getdtrfromtransport(new.idtransport))) THEN
				call ERROR_INSERT_NOT_ALLOWED ();
			END IF;

		-- cas client
		ELSEIF gettypeutilisateur(new.idutilisateur1) = 'client' THEN
			IF !(verifclient(new.idutilisateur1, getdtrfromtransport(new.idtransport)) AND veriftransport(new.idutilisateur2, getdtrfromtransport(new.idtransport))) THEN
				call ERROR_INSERT_NOT_ALLOWED ();
			END IF;
		ELSE
			call ERROR_INSERT_NOT_ALLOWED ();
		END IF;
END;//
delimiter ;
-- GO
SET FOREIGN_KEY_CHECKS=1;
-- GO

