describe('Teste para Gerenciar as Perguntas Frequentes (FaQ)', () => {
    it('Cadastrar uma nova pergunta frequente', () => {
        cy.visit('/painel/faq');

        cy.get('#question').should('be', 'exists');
        cy.get('#answer').should('be', 'exists');

        cy.get('#question').type('Pergunta 01');
        cy.get('#answer').type('Resposta 01');
        cy.get('[type="submit"]').click();
    });
});
