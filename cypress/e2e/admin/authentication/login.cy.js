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

        cy.get('[data-cy="email"]').type('chiquim@email.com');
        cy.get('[data-cy="password"]').type('12345678');

        cy.contains('Esqueci minha senha');
        cy.contains('Cadastre-se');

        cy.get('[data-cy="submit"]').click();
    })
})
