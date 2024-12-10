describe('Teste de acesso à FAQ e interação com os cards', () => {
    beforeEach(() => {
        cy.visit('/faq');
    });

    it('Deve abrir os modais ao clicar nos ícones dos cards', () => {
        cy.scrollTo('bottom');

        cy.get('.card-faq-item')
            .should('be.visible')
            .each(($card) => {
                const modalTarget = $card.find('i').attr('data-bs-target');
                cy.wrap($card).find('i').click();
                cy.wait(500);
                cy.get(modalTarget)
                    .should('be.visible');
                cy.get(`${modalTarget} .btn-close`).click();
                cy.get(modalTarget).should('not.be.visible');
            });
    });
});
