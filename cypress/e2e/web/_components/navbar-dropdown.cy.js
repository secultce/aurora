describe('Teste de Dropdown do Navbar após Login', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.contains('Sara Jenifer Camilo').should('be.visible');
    });

    it('Verifica se o botão do dropdown está visível e funcional', () => {
        cy.get('#dropdownMenuButton').should('be.visible');

        cy.get('#dropdownMenuButton').click();

        cy.get('#customDropdown').should('be.visible');
    });

    it('Verifica a funcionalidade completa do dropdown do navbar', () => {
        cy.get('#dropdownMenuButton').click();

        cy.get('#customDropdown').within(() => {
            cy.contains('Painel de Controle').should('be.visible');
            cy.contains('Minhas Oportunidades').should('be.visible');
            cy.contains('Minhas Inscrições').should('be.visible');
            cy.contains('Minhas Avaliações').should('be.visible');
            cy.contains('Meus Agentes').should('be.visible');
            cy.contains('Meus Espaços').should('be.visible');
            cy.contains('Meus Eventos').should('be.visible');
            cy.contains('Minhas Iniciativas').should('be.visible');
            cy.contains('Conta e Privacidade').should('be.visible');
            cy.contains('Meu Perfil').should('be.visible');
            cy.contains('Sair').should('be.visible');
        });

        cy.get('#customDropdown').should('be.visible');

        cy.get('body').click(0, 0);

        cy.get('#customDropdown').should('not.be.visible');

        cy.get('#dropdownMenuButton').click();

        cy.get('#customDropdown').should('be.visible');

        cy.contains('Minhas Inscrições').click();

        cy.get('#customDropdown').should('not.be.visible');

        cy.url().should('include', '/painel/inscricoes/');
    });
});
