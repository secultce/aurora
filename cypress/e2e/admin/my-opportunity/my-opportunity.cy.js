describe('Página de Minhas Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/painel/minhas-oportunidades');
    });

    it('Deve verificar a URL da página de Minhas Oportunidades', () => {
        cy.url().should('include', '/painel/minhas-oportunidades');
    });

    it('Deve verificar a presença do título da página', () => {
        cy.get('h1').contains('Minhas Oportunidades');
    });

    it('Deve verificar a presença do campo de busca por palavra-chave', () => {
        cy.get('input[placeholder="Busque por palavras-chave"]').should('exist');
    });

    it('Deve verificar a presença do card de oportunidade', () => {
        cy.get('.card-opportunity').should('exist');
    });

    it('Deve verificar a presença dos botões Arquivar e Excluir', () => {
        cy.get('.btn-archive').contains('Arquivar').should('exist');
        cy.get('.btn-delete').contains('Excluir').should('exist');
    });

    it('Deve verificar a presença dos botões Conferir e Editar', () => {
        cy.get('.btn-outline-primary').contains('Conferir').should('exist');
        cy.get('.btn-edit').contains('Editar').should('exist');
    });
});
