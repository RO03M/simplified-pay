all: remove_docker_deps setup

remove_docker_deps:
	@docker compose down

remove_docker_deps_with_volume:
	@docker compose down -v

setup:
	@docker compose up -d
	@docker exec simplified_pay_backend php artisan optimize; sleep 2; php artisan migrate