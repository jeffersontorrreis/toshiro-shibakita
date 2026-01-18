.PHONY: help up down restart logs clean build

help: ## Mostra esta mensagem de ajuda
	@echo "Comandos disponíveis:"
	@echo "  make up       - Inicia todos os containers"
	@echo "  make down     - Para todos os containers"
	@echo "  make restart  - Reinicia todos os containers"
	@echo "  make logs     - Mostra logs de todos os serviços"
	@echo "  make clean    - Remove containers e volumes"
	@echo "  make build    - Reconstrói as imagens"
	@echo "  make status   - Mostra status dos containers"

up: ## Inicia todos os containers
	docker-compose up -d
	@echo "✓ Containers iniciados!"
	@echo "Acesse: http://localhost"

down: ## Para todos os containers
	docker-compose down
	@echo "✓ Containers parados!"

restart: down up ## Reinicia todos os containers

logs: ## Mostra logs de todos os serviços
	docker-compose logs -f

clean: ## Remove containers, volumes e limpa sistema
	docker-compose down -v
	docker system prune -f
	@echo "✓ Limpeza completa realizada!"

build: ## Reconstrói as imagens
	docker-compose build --no-cache
	@echo "✓ Imagens reconstruídas!"

status: ## Mostra status dos containers
	docker-compose ps
