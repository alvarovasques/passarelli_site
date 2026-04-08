# Implantação no VPS com Portainer e Traefik

O site legado foi adaptado com sucesso para ser publicado via Docker e se integrar à rede do Traefik.

## O que foi feito:

1. **Dockerfile PHP 7.4**: Criado um `Dockerfile` leve baseado em `php:7.4-apache`. O PHP 7.4 é uma versão excelente para aplicações legadas, com as extensões `pdo`, `pdo_mysql` e `mysqli` ativadas nativamente. A pasta raiz configurada aponta para a pasta do site (`public_html/public_html`).
2. **docker-compose.yml pronto para o Traefik**:
   - Cria o serviço `app` exposto com *labels* padrão do Traefik. Ele escuta uma variável `${DOMAIN}` para aplicar o roteamento final (ex: `passarelli.seudominio.com.br`).
   - Cria o serviço `db` (MariaDB). Ele automaticamente inicializa varrendo e carregando o `passarel_passare.sql` do repositório no primeiro *startup*.
3. **Credenciais Dinamizadas**: O arquivo `public_html/public_html/ga-admin/includes/config_inc.php` foi refatorado. Agora ele lê primeiramente as variáveis de ambiente passadas pelo Docker Compose (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) sem perder as credenciais originais (usadas como *fallback* de segurança).

## Como publicar via Portainer

1. Envie a pasta `passarelli` completa para um repositório no seu GitHub (pode ser privado).
2. Acesse o **Portainer** e vá em **Stacks** -> **Add stack**.
3. Selecione o método **Repository** e cole a URL do seu GitHub.
4. Na seção **Environment variables**, você não precisará configurar o domínio, pois ele já vai assumir o padrão `passarelli.adv.br`. (Você só precisará adicionar a variável `DOMAIN` caso queira testar com outro endereço provisório).
5. Role até **Deploy the stack** e clique.

> [!TIP]
> A stack agora já utiliza a rede externa correta do seu Traefik chamada `di4e`, conforme solicitado.
