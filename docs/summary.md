⚠️ **Todos os endpoints exigem este cabeçalho:**

```bash
'content-type': 'application/json'
```

⚠️ **Todas as respostas seguem esta estrutura:**

```bash
'code': 'http status code',
'message': 'mensagem descrevendo o sucesso ou erro',
'return': 'algumas funções possuem retorno'
```

⚠️ **Todas as informações nos corpos das requisições são obrigatórias até que dito o contrário.**

⚠️ **A maioria das requisições exige um cabeçalho de requisição com Cookie PHPSESSID seguindo este formato:**

```bash
'content-type': 'application/json'
'cookie': 'PHPSESSID=?'
```

# Índice

1. Autenticação<br>
1.1. [Criação de conta](./auth.md#criação-de-conta)<br>
1.2. [Login](./auth.md#login)<br>
1.3. [Atualização de informações](./auth.md#atualização-de-informações)<br>
1.4. [Deleção de conta](./auth.md#deleção-de-conta)<br>
1.5. [Logout](./auth.md#logout)

2. Brinquedo<br>
2.1. [Criar](./play.md#criar)<br>
2.2. [Listar (cliente)](./play.md#listar-cliente)<br>
2.3. [Listar (empresa)](./play.md#listar-empresa)<br>
2.4. [Atualizar](./play.md#atualizar)<br>
2.5. [Deletar](./play.md#deletar)<br>

3. Avaliação<br>
3.1. [Criar](./feedback.md#criar)<br>
3.2. [Listar](./feedback.md#listar)

4. Visita<br>
4.1. [Criar](./visit.md#criar)<br>
4.2. [Listar (cliente)](./visit.md#listar-cliente)<br>
4.3. [Listar (empresa)](./visit.md#listar-empresa)

5. Favorito<br>
5.1. [Favoritar](./favorite.md#favoritar)<br>
5.2. [Listar (cliente)](./favorite.md#listar-cliente)<br>
5.3. [Listar (empresa)](./favorite.md#listar-empresa)<br>
5.4. [Desfavoritar](./favorite.md#desfavoritar)