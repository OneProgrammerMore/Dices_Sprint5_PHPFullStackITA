# Dices App

The main goal of this project is to program the API REST for a simple game of dices, which consists in throwing two dices, adding the results and if the sum is 7 the player wins the games.

Several other routes have been programmed as the exercise asked for:

```
Has de tindre en compte els següents detalls de construcció:

URL’s:

    POST /players : crea un jugador/a.
    PUT /players/{id} : modifica el nom del jugador/a.
    POST /players/{id}/games/ : un jugador/a específic realitza una tirada dels daus.
    DELETE /players/{id}/games: elimina les tirades del jugador/a.
    GET /players: retorna el llistat de tots els jugadors/es del sistema amb el seu percentatge mitjà d’èxits 
    GET /players/{id}/games: retorna el llistat de jugades per un jugador/a.
    GET /players/ranking: retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits.
    GET /players/ranking/loser: retorna el jugador/a amb pitjor percentatge d’èxit.
    GET /players/ranking/winner: retorna el jugador/a amb millor percentatge d’èxit.
```

Furthermore an AJAX React Application has been made in order to access all endpoints of the application.


# ToDo
Several things can be improved for the next version of this project:

API REST:  
- [ ] Adding SQL Transactions
- [ ] Adding Service Layer
- [ ] Endpoint in order to obtain type of user

REACT APP:
- [ ] Changing Font Type
- [ ] Improving Design
- [ ] Use ThreeJS in order to make a 3D animation for the dices
- [ ] Change Colour Schema 
- [ ] Use new endpoint for user type discovery
- [x] Images are not "compiled" automatically into the project




# DOCUMENTATION

- Nginx

	Official page: http://nginx.org/en/docs/
	
	Configuration: https://www.nginx.com/resources/wiki/start/topics/examples/full/
	
	Configuration File: https://www.nginx.com/resources/wiki/start/topics/examples/full/
	
	Begginers Guide: http://nginx.org/en/docs/beginners_guide.html
	
	Security: https://docs.nginx.com/nginx/admin-guide/security-controls/
	
	Bug List: https://bugs.launchpad.net/nginx
	
	Realeases: https://docs.nginx.com/nginx/releases/
	
	Alarming EMAIL: https://www.nginx.com/resources/wiki/community/get_involved/
	
	Repository: http://hg.nginx.org/nginx/
	
	
- Apache  
	Official page: https://httpd.apache.org/docs/  
	Configuration: https://httpd.apache.org/docs/2.4/configuring.html  
	Security: https://httpd.apache.org/docs/2.4/misc/security_tips.html  
	Bug List: https://bugs.apache.org/  
	Alarming EMAIL: https://www.apache.org/security/  
	Repository: https://github.com/apache/httpd  

- Alpine  
	Official page: https://www.alpinelinux.org/  
	Documentation: https://docs.alpinelinux.org/user-handbook/0.1a/index.html  
	Configuration: https://wiki.alpinelinux.org/wiki/Installation  
	Security: https://wiki.alpinelinux.org/wiki/Alpine_Security_and_Rescue  
	Bug List: https://alpinelinux.org/releases/  
	Alarming EMAIL: https://www.alpinelinux.org/community/  
	Repository: https://gitlab.alpinelinux.org/alpine  

- MariaDB  
	Official page: https://mariadb.com/  
	Configuration: https://mariadb.com/kb/en/configuring-mariadb-with-option-files/  
	Security: https://mariadb.com/kb/en/securing-mariadb/  
	Bug List: https://bugs.launchpad.net/bugs/bugtrackers/mariadb-bugs  
	Bug Reporting Official: https://mariadb.com/kb/en/reporting-bugs/  
	Alarming EMAIL:   
		https://mariadb.com/docs/xpand/service-management/xpand-monitoring/email-alerts/  
		https://mariadb.com/kb/en/security/  
	Repository:  
		https://mariadb.com/kb/en/mariadb-package-repository-setup-and-usage/  
		https://github.com/MariaDB/server  

- Docker  
	Official page: https://www.docker.com/  
	Documentation:  https://docs.docker.com/  
	Configuration: https://docs.docker.com/reference/cli/docker/config/  
	Security: https://docs.docker.com/engine/security/  
	Bug List:  
		https://github.com/docker/for-linux/issues  
		https://docs.docker.com/desktop/troubleshoot/known-issues/  
		https://docs.docker.com/release-notes/  
	Alarming EMAIL:  
	Images Official: https://hub.docker.com/_/docker/  
	Repository: https://github.com/docker  
	Docker Compose.yaml Doc: https://docs.docker.com/compose/compose-file/compose-file-v3/  

- React  
	Official page:  
	Configuration:  
	Security:  
	Bug List:  
	Alarming EMAIL:  

- Javascript  
	Official page:  
	Configuration:  
	Security:  
	Bug List:  
	Alarming EMAIL:  

- Php  
	Official page:  
	Configuration:  
	Security:  
	Bug List:  
	Alarming EMAIL:  

- Laravel  
	Official page:  
	Configuration:  
	Security:  
	Bug List:  
	Alarming EMAIL:  

- NodeJS  
	Official page:  
	Configuration:  
	Security:  
	Bug List:  
	Alarming EMAIL:  

