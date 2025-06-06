# BrincAqui

## Pré-requisitos
- **PHP**: instale a versão mais atual clicando [aqui](https://www.php.net/downloads.php);
- **xampp**: instale a versão mais atual clicando [aqui](https://www.apachefriends.org/pt_br/download.html);

## Instalação
Clone o repositório
```bash
git clone https://www.github.com/lumahloi/brincaqui.git
```

## Configuração
Para usar o **Backend**, copie o exemplo de `.env` para a pasta `api`.
```bash
cp .env.example api/.env
```

Atribua valor às variáveis do `.env`.
- `DB_HOST`: nome do host;
- `DB_NAME`: nome do banco de dados;
- `DB_USER`: usuário do banco de dados;
- `DB_PASSWORD`: senha do banco de dados.

Em `localhost/phpmyadmin`, crie o banco de dados usando o script fornecido em `api/utils/database_scripts/create_database.sql`

## Rodando localmente
- Jogue todo o conteúdo para a pasta `htdocs` do `xampp`.
- Acesse `localhost/brincaqui` pelo navegador.

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
Acesse a documentação completa clicando [aqui](./docs/apis.md).

## Autores
