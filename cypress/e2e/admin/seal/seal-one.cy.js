describe('Página de listar Selos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/selos/123');
    });

    it('Garante que a página do selo existe', () => {
        cy.get('.seal-info > :nth-child(2) > .fs-4').contains('Seal Name').should('be.visible');
        cy.get('.seal-info > :nth-child(2) > p').contains('Ac massa').should('be.visible');
    });

    it('Garante que a validade do selo esteja visível', () => {
        cy.get(':nth-child(1) > .fs-4').contains('Validade').should('be.visible');
        cy.get('.seal-validity').contains('28 de dezembro a 29 de outubro de 2025').should('be.visible');
    });

    it('Garante que a descrição do selo esteja visível', () => {
        cy.get('div.mb-4 > .fs-4').contains('Descrição').should('be.visible');
        cy.get('div.mb-4 > p').contains('Ac massa tempus mattis dictum.').should('be.visible');
    });

    it('Garante que os arquivos de download estejam visíveis', () => {
        cy.get('.seal-files > .list-unstyled > :nth-child(1) > .text-decoration-none > span').contains('Arquivo de anexo').should('be.visible');
    });

    it('Garante que os links estejam visíveis', () => {
        cy.get('.seal-links > .list-unstyled > :nth-child(1) > .text-decoration-none > span').contains('Link de algo').should('be.visible');
    });

    it('Garante que o gestor da oportunidade esteja visível', () => {
        cy.get('.d-flex > .fw-bold').contains('Gestor da oportunidade').should('be.visible');
    });

    it('Garante que os agentes relacionados estejam visíveis', () => {
        cy.get('.list-unstyled > :nth-child(1) > a > img').should('be.visible');
    });
})
