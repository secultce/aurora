describe('Pagina Admin de teste', () => {
    it('Acessa e exibe o conteúdo da página', () => {
        cy.visit('/admin/example')
        cy.get('h1').should('contain', 'Olá mundo')
        cy.contains('Aurora').should('be.visible')
    })
})
