describe('Teste de Login no Projeto Aurora', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.contains('Sara Jenifer Camilo').should('be.visible');
    });

    it('Deve acessar a página de espaços', () => {
        cy.visit('/espacos');

        cy.url().should('include', '/espacos');
    });

    it('Deve clicar no botão "Criar espaço" e verificar a URL', () => {
        cy.visit('/espacos');

        cy.contains('Criar espaço').click();

    });
});
