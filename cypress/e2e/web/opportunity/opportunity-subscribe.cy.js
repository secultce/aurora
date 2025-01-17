describe('Página de listar Oportunidades, botão de inscrição', () => {
    it('Garante que os cards de oportunidades estão visíveis e o botão de inscrição funciona', () => {
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.viewport(1920, 1080);
        cy.visit('/oportunidades');

        cy.get('[data-cy="pills-list-content"] > :nth-child(2) > .opportunity-card-header').contains('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino').should('be.visible');
        cy.get('[data-cy="pills-list-content"] > :nth-child(2) button[data-bs-target="#modalActionConfirm"]').contains('Inscreva-se').click();
        cy.get('a[data-modal-button="confirm-link"]').contains('Confirmar').click();
        cy.url().should('include', '/painel/inscricoes');
        cy.contains('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino');
    });
})
