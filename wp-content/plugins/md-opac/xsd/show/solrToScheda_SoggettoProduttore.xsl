<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="solrToScheda_Md.xsl"/>
    
    <xsl:template match="arr[@name='altreDenominazioni_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Altre Denominazioni
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='dataEsistenza_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data di esistenza
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='dataMorte_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data di Morte
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='luogoNascita_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Luogo di Nascita
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='luogoMorte_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Luogo di Morte
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='sede_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Sede
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='naturaGiuridica_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Natura Giuridica
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='tipoEnte_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Tipo Ente
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='ambitoTerritoriale_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Ambito territoriale
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='titoloSP_show']">
         <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Titolo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                       
                            <xsl:copy-of select="child::text()"/>
                       
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>
