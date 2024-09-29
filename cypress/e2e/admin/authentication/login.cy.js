describe('Pagina de Login do ambiente web', () => {
    beforeEach(() => {
        cy.visit('/login')
    });

    it('Garante que a página de login existe', () => {
        cy.contains('Oportunidades');
        cy.contains('Agentes');
        cy.contains('Eventos');
        cy.contains('Espaços');
        cy.contains('Iniciativas');

        cy.get('p')
            .contains('Boas vindas!');

        cy.contains('Entre com a sua conta.');
        cy.contains('Entrar');
    })

    it('Garante que a mensagem de credenciais inválidas existe', () => {
        cy.get('[data-cy="email"]').type('chiquim@email.com');
        cy.get('[data-cy="password"]').type('12345678');

        cy.contains('Esqueci minha senha');
        cy.contains('Cadastre-se');

        cy.get('[data-cy="submit"]').click();

        cy.contains('Credenciais inválidas.');
    })


    it('Garante que após o login ser efetuado será redirecionado para a tela home', () => {
        cy.get('[data-cy="email"]').type('paulodetarso@example.com');
        cy.get('[data-cy="password"]').type('cartas');

        cy.contains('Esqueci minha senha');
        cy.contains('Cadastre-se');

        cy.get('[data-cy="submit"]').click();

        cy.url().should('include', '/');
    })
})