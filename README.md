# BrincAqui

## Pré-requisitos
- **PHP**: instale a versão mais atual clicando [aqui](https://www.php.net/downloads.php);
- MySQL WorkBench
- Docker

## Instalação
Clone o repositório
```bash
git clone https://www.github.com/lumahloi/brincaqui.git
```

## Configuração
Copie o exemplo de `.env` para a pasta `api`.
```bash
cp .env.example api/.env
```

Atribua valor às variáveis do `.env`.
- `DB_HOST`: nome do host;
- `DB_NAME`: nome do banco de dados;
- `DB_USER`: usuário do banco de dados;
- `DB_PASSWORD`: senha do banco de dados;
- `SESSION_ID`: string de sessão retornada ao realizar login, necessária para consumir a maioria das APIs;
- `API_KEY`: chave para requisitar a API externa.

Crie uma conexão com o banco de dados MySQL.

Crie o banco de dados usando o script fornecido em `api/utils/create_database.sql`

## Rodando localmente
- Execute o comando:
```bash
docker-compose up --build
```
- Acesse `localhost:8000` pelo navegador.

## Alteração
⚠️ **Antes de qualquer alteração, garanta que o repositório esteja atualizado.** 

Garanta que esteja na branch `develop`.
```bash
git checkout develop
```

Verifique se há alterações na origem.
```bash
git pull origin develop
```

Faça as modificaçãos desejadas. Terminadas, adicione ao Git.
```bash
git add <comando>
```

Descreva suas modificações. Procure fazer modificações pequenas e faça uma boa descrição.
```bash
git commit -m "<mensagem>"
```

## Contribuição
Dê push na branch.
```bash
git push origin develop
```

## APIs
Acesse a documentação completa clicando [aqui](./docs/summary.md).

## Autores
