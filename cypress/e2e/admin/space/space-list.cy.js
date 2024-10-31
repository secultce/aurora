describe('Painel de Controle - Página de listar Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/espacos');
    });

    it('Garante que a página de Espaços existe', () => {
        cy.get('h2').contains('Meus Espaços').should('be.visible');

        cy.contains('Dragão do Mar').should('be.visible');
        cy.contains('Galeria Caatinga').should('not.exist');
    });

    it('Garante que os espaços estejam visíveis ', () => {
        cy.get('tbody > :nth-child(2) > :nth-child(1) > a').contains('Casa da Capoeira').should('be.visible');
        cy.get('tbody > :nth-child(2) > :nth-child(2)').contains('13/08/2024 20:25:00').should('be.visible');
    });

    it('Garante que um espaço pode ser excluído', () => {
        cy.get('h2').contains('Meus Espaços').should('be.visible');

        cy.get('[data-cy="remove-2"]').contains('Excluir').click();

        cy.contains('Confirmar').click();

        cy.contains('Casa da Capoeira').should('not.exist');
    });
})
