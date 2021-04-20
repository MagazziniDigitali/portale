<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="solrToScheda_Md.xsl"/>
    
    <xsl:template match="arr[@name='altreDenominazioni_show']">
        <tr>
            <td id="testo">
                Altre Denominazioni
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='dataEsistenza_show']">
        <tr>
            <td id="testo">
                Data di esistenza
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='dataMorte_show']">
        <tr>
            <td id="testo">
                Data di Morte
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='luogoNascita_show']">
        <tr>
            <td id="testo">
                Luogo di Nascita
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='luogoMorte_show']">
        <tr>
            <td id="testo">
                Luogo di Morte
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='sede_show']">
        <tr>
            <td id="testo">
                Sede
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='naturaGiuridica_show']">
        <tr>
            <td id="testo">
                Natura Giuridica
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='tipoEnte_show']">
        <tr>
            <td id="testo">
                Tipo Ente
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='ambitoTerritoriale_show']">
        <tr>
            <td id="testo">
                Ambito territoriale
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="arr[@name='titoloSP_show']">
        <tr>
            <td id="testo">
                Titolo
            </td>
            <td id="value">
                <xsl:for-each select="str">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                        <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>
