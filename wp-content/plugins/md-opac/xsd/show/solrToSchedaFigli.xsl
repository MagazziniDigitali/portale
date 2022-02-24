<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:template match="/">
        <h4>Altre informazioni</h4>
        <table class="table table-border" id="schedaFigli">
            <xsl:apply-templates select="//response/result/doc"/>
        </table>
    </xsl:template>
    
    <xsl:template match="//response/result/doc">
        <tr>
            <td class="label-dettaglio-border" id="value">
                <a title="bid">
                    <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="str[@name='id']" />');</xsl:attribute>
                    <xsl:if test="arr[@name='titolo_show']">
                       
                            <xsl:copy-of select="arr[@name='titolo_show']"/>  
                        
                    </xsl:if>
                    <xsl:if test="not(arr[@name='titolo_show'])">
                        <xsl:if test="arr[@name='originalFileName_show']">
                           
                                <xsl:if test="contains(arr[@name='originalFileName_show'], '/Validate/')">
                                  <xsl:value-of select="substring-after(arr[@name='originalFileName_show'], '/Validate/')"/>
                                </xsl:if>
                                <xsl:if test="not(contains(arr[@name='originalFileName_show'], '/Validate/'))">
                                  <xsl:copy-of select="arr[@name='originalFileName_show']"/>
                                </xsl:if>
                            
                        </xsl:if>
                        <xsl:if test="not(arr[@name='originalFileName_show'])">
                            <xsl:if test="arr[@name='eventType_show']">
                                Evento:<xsl:copy-of select="arr[@name='eventType_show']"/>
                                Esito:<xsl:copy-of select="arr[@name='eventOutCome_show']"/>
                                Periodo:<xsl:copy-of select="arr[@name='eventDate_show']"/>
                            </xsl:if>
                            <xsl:if test="not(arr[@name='eventType_show'])">
                                [Senza descrizione]  
                            </xsl:if>
                        </xsl:if>
                    </xsl:if>
                </a>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
