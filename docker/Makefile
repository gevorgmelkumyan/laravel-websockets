purge env:
	rm .env
	rm ../.env

run:
	chmod +x update.env.sh
	bash update.env.sh
	docker compose up --build -d

stop:
	docker compose stop

down:
	docker compose down

server_run:
	docker exec -it lw_server bash
