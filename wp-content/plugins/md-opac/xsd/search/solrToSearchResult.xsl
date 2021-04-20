<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <xsl:if test="//response/result/doc">
            <table class="mdResultRice">
                <xsl:apply-templates select="//response/result/doc"/>
            </table>
        </xsl:if>
        <xsl:if test="not(//response/result/doc)">
            <h1>Non risultano oggetti da visualizzare</h1>
        </xsl:if>
    </xsl:template>
    <xsl:template match="//response/result/doc">
        <tr>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">pari</xsl:attribute>
            </xsl:if>
            <td>
                <!--
            	tipoOggetto_show: <xsl:copy-of
                    select="arr[@name='tipoOggetto_show']/str"/><br/>
-->
                <a title="breve">
                    <xsl:for-each select="str[@name='id']">
                        <xsl:attribute name="onclick"
                            >
                            showScheda('<xsl:copy-of
                                select="child::text()"/>');</xsl:attribute>
                    </xsl:for-each>
                    
                    <xsl:choose>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='contenitore'">
                            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>
                            <xsl:apply-templates select="arr[@name='mimeType_show']"/>
                            <xsl:apply-templates select="arr[@name='size_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='documento'">
                            <xsl:apply-templates select="arr[@name='autore_show']"/>
                            <xsl:apply-templates select="arr[@name='titolo_show']"/>
                            <xsl:apply-templates select="arr[@name='data_show']"/>
                            <xsl:apply-templates select="arr[@name='inventario_show']"/>
                            <xsl:apply-templates select="arr[@name='collocazione_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='evento'">
                            <xsl:apply-templates select="arr[@name='eventType_show']"/>
                            <xsl:apply-templates select="arr[@name='eventDate_show']"/>
                            <xsl:apply-templates select="arr[@name='eventOutCome_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='file'">
                            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>
                            <xsl:apply-templates select="arr[@name='size_show']"/>
                            <xsl:apply-templates select="arr[@name='mimeType_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='SchedaF'">
                            <xsl:apply-templates select="arr[@name='titolo_show']"/>
                            <xsl:apply-templates select="arr[@name='autore_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='SoggettoConservatore'">
                            <xsl:apply-templates select="arr[@name='titolo_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='ComplessoArchivistico'">
                            <xsl:apply-templates select="arr[@name='titolo_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='agente'">
                            <xsl:apply-templates select="arr[@name='agentName_show']"/>
                            <xsl:apply-templates select="arr[@name='agentType_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='diritti'">
                            <xsl:apply-templates select="arr[@name='rightsBasis_show']"/>
                        </xsl:when>
                        <xsl:when test="arr[@name='tipoOggetto_show']/str='registro'">
                            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>
                        </xsl:when>
                        <xsl:otherwise>
                            ALTRO
                            <xsl:apply-templates select="arr[@name='tipoOggetto_show']"/>
                            <xsl:apply-templates select="arr[@name='originalFileName_show']"/>
                        </xsl:otherwise>
                    </xsl:choose>
                    
                </a>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='data_show']">
        Data: 
        <xsl:for-each select="str">
            <b><xsl:copy-of select="."/></b><br/>
        </xsl:for-each>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentName_show']">
        Nome Agente: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentType_show']">
        Tipo Agente: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='rightsBasis_show']">
        Rigths Basis: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='originalFileName_show']">
        Nome file Originale: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='mimeType_show']">
        Tipo File: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='size_show']">
        Dimensione: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='autore_show']">
        Autore: <b>
            <xsl:copy-of select="str"/>
        </b><br/>
    </xsl:template>
    
    <xsl:template match="arr[@name='titolo_show']">
        <xsl:choose>
            <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore'">
                Istituto:
            </xsl:when>
            <xsl:when test="../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                Complesso Archivistico:
            </xsl:when>
            <xsl:otherwise>
                Titolo:
            </xsl:otherwise>
        </xsl:choose>
        <xsl:for-each select="str">
            <xsl:if test="position()>1">
                <xsl:text disable-output-escaping="yes">&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;</xsl:text>
            </xsl:if>
            <b><xsl:copy-of select="."/></b><br/>
        </xsl:for-each>
    </xsl:template>
    
    <xsl:template match="arr[@name='inventario_show']">
        Inventario: <b>
            <xsl:for-each select="str">
                <xsl:if test="position()>1">, </xsl:if>
                <xsl:copy-of select="."/>
            </xsl:for-each>
        </b><br/>
    </xsl:template>
    
    <xsl:template match="arr[@name='collocazione_show']">
        Collocazione: <b>
            <xsl:for-each select="str">
                <xsl:if test="position()>1">, </xsl:if>
                <xsl:copy-of select="."/>
            </xsl:for-each>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventType_show']">
        Tipo Evento: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventDate_show']">
        <xsl:for-each select="str">
            <xsl:if test="position()=1">Data Inizio Evento: </xsl:if>
            <xsl:if test="position()>1">Data Fine Evento: </xsl:if>
            <b><xsl:copy-of select="."/></b>
        </xsl:for-each>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventOutCome_show']">
        Esito: <b>
            <xsl:copy-of select="str"/>
        </b>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoOggetto_show']">
        Tipo Oggetto:
        <b><xsl:copy-of select="str"/></b>
    </xsl:template>
</xsl:stylesheet>