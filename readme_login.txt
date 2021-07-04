Ablaufschema beim Aufruf des controllers

Wenn $_SESSION['user'] gesetzt
	Wenn user vom Typ Admin
		Wenn timeout
			Rufe die logout Methode des AdminControllers auf
		Sonst
			Gehe zurück zur AdminController Routine
	Sonst
		rufe Logic Handler auf
			Wenn Anfrage per Javascript
				Wenn $_SESSION['user'] gesetzt	
						Prüfe auf Timeout
				Sonst
						Weiter
			Sonst
				rufe type Handler auf
					Wenn Login
						rufe Login Routine auf
							Wenn aus Javascript aufgerufen (wie sonst???)
								Überprüfe Logindaten mit checkLoginByCreds
									Wenn Passwort und Name korrekt
										gebe true zurück 
									Sonst
										gebe false zurück
								Beende Routine und gebe JSON Array zurück
							Sonst
								Ausgabe Fehlermeldung
					Sonst
						rufe Default
							Wenn $_SESSION['user'] gesetzt
								Prüfe auf Usertyp
							Sonst
Sonst
	rufe Logic Handler auf
		Wenn Anfrage per Javascript
			
		Sonst
			rufe type Handler auf
