describe('Painel de Controle - Página de timeline dos Usuários', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/admin/usuarios/4ed47ceb-8415-4710-a072-3de52843c616/timeline');
    });

    it('Garante que a página de timeline existe', () => {
        cy.get('h2').contains('Usuário - Talyson Soares - Timeline').should('be.visible');
        cy.get('.d-flex > div > .btn').contains('Voltar').should('be.visible');
    });

    it('Garante que os dados dos usuários estão visíveis', () => {
        cy.get('tr > :nth-child(1) > a').contains('The resource was created').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains(/\d{2}\/\d{2}\/\d{4}/).should('be.visible');
        cy.get('tbody > tr > :nth-child(3)').contains('unknown').should('be.visible');
        cy.get(':nth-child(5) > .btn').contains('Detalhes').should('be.visible')
    });
})
