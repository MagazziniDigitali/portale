<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="schedaF.xsl"/>
    
    <xsl:template match="arr[@name='soggettoConservatore_show']">
        <tr>
            <td id="testoB">
                Soggetto conservatore 
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </xsl:if>
                    <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                        <a>
                            <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />');</xsl:attribute>
                            <!-- xsl:attribute name="onclick">findTeca('soggettoConservatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                            <b>
                                <xsl:copy-of select="child::text()"/>
                            </b>
                        </a>
                    </xsl:if>
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="(../../arr[@name='soggettoConservatoreScheda_show']/str[position()=$myPos]/child::text() and not(../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')) or (../../arr[@name='soggettoConservatoreKey_show']/str[position()=$myPos]/child::text() and ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                        <xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
                        <a title="Visualizza Scheda" alt="Visualizza Scheda" id="showScheda">
                            <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str[position()=$myPos]/child::text()" />');</xsl:attribute>
                            <img alt="Visualizza Scheda" class="objDigit" src="./plugins/content/tecadigitale/images/find.ico"/>
                        </a>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='fondo_show']">
        <tr>
            <td id="testoB">
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore'">
                    Complesso Archivistico
                </xsl:if>
                <xsl:if test="not(../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore')">
                    Fondo
                </xsl:if>
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </xsl:if>
                    <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore' or ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                        <a>
                            <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='fondoKey_show']/str/child::text()" />');</xsl:attribute>
                            <!-- xsl:attribute name="onclick">findTeca('fondo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                            <b>
                                <xsl:copy-of select="child::text()"/>
                            </b>
                        </a>
                    </xsl:if>
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="(../../arr[@name='fondoScheda_show']/str[position() = $myPos]/child::text() and 
                        not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore')) or 
                        (../../arr[@name='fondoKey_show']/str[position() = $myPos]/child::text() and 
                        ../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore')">
                        <xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
                        <a title="Visualizza Scheda" alt="Visualizza Scheda" id="showScheda">
                            <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore'">
                                <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='fondoKey_show']/str[position()=$myPos]/child::text()" />');</xsl:attribute>
                            </xsl:if>
                            <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoProduttore')">
                                <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str[1]/child::text()" />.<xsl:copy-of select="../../arr[@name='fondoKey_show']/str[position()=$myPos]/child::text()" />');</xsl:attribute>
                            </xsl:if>
                            <img alt="Visualizza Scheda" class="objDigit" src="./plugins/content/tecadigitale/images/find.ico"/>
                        </a>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='subFondo_show']">
        <tr>
            <td id="testoB">
                Sotto Livelli
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='fondoKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='subFondoKey_show']/str/child::text()" />');</xsl:attribute>
                        <!--xsl:attribute name="onclick">findTeca('subFondo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute-->
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a>
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="not (../../arr[@name='subFondoScheda_show']/str[position() = $myPos]/child::text()='No')">
                        <xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
                        <a title="Visualizza Scheda" alt="Visualizza Scheda" id="showScheda">
                            <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='subFondoScheda_show']/str[position()=$myPos]/child::text()" />');</xsl:attribute>
                            <img alt="Visualizza Scheda" class="objDigit" src="./plugins/content/tecadigitale/images/find.ico"/>
                        </a>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='subFondo2_show']">
        <tr>
            <td id="testoB">
                <xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='fondoKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='subFondoKey_show']/str/child::text()" />', '<xsl:copy-of select="../../arr[@name='subFondo2Key_show']/str/child::text()" />');</xsl:attribute>
                        <!-- xsl:attribute name="onclick">findTeca('subFondo2','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipologiaMateriale_show']">
        <tr>
            <td id="testo">
                Tipologia materiale cartografico
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('tipologiaMateriale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='dataCronica_show']">
        <tr>
            <td id="testo">
                Data cronica
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('dataCronica','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='dataTopica_show']">
        <tr>
            <td id="testo">
                Data topica
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('dataTopica','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='supporto_show']">
        <tr>
            <td id="testo">
                Supporto
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('supporto','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tecnica_show']">
        <tr>
            <td id="testo">
                Tecnica
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('tecnica','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='dimensione_show']">
        <tr>
            <td id="testo">
                Dimensioni
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('dimensione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='scala_show']">
        <tr>
            <td id="testo">
                Scala
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('scala','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='statoConservazione_show']">
        <tr>
            <td id="testo">
                Stato di conservazione
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('statoConservazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='datiFruizione_show']">
        <tr>
            <td id="testo">
                Dati di fruizione
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('datiFruizione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='compilatore_show']">
        <tr>
            <td id="testo">
                Nome compilatore
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('compilatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='dataCompilazione_show']">
        <tr>
            <td id="testo">
                Data di compilazione
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('dataCompilazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipologiaUnitaArchivistica_show']">
        <tr>
            <td id="testo">
                <xsl:text disable-output-escaping="yes">Tipologia Unit&amp;agrave; Archivistica</xsl:text>
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('tipologiaUnitaArchivistica','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='annoIniziale_show']">
        <tr>
            <td id="testo">
                Anno Iniziale
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('annoIniziale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='annoFinale_show']">
        <tr>
            <td id="testo">
                Anno Finale
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('annoFinale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='secoloIniziale_show']">
        <tr>
            <td id="testo">
                Secolo Iniziale
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('secoloIniziale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='secoloFinale_show']">
        <tr>
            <td id="testo">
                Secolo Finale
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('secoloFinale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='consistenzaCarte_show']">
        <tr>
            <td id="testo">
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                    Consistenza
                </xsl:if>
                <xsl:if test="not(../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                    Consistenza carte scritte
                </xsl:if>
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore') and
                        not(../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                        <a>
                            <xsl:attribute name="onclick">findTeca('consistenzaCarte','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <b>
                                <xsl:copy-of select="child::text()"/>
                            </b>
                        </a>
                    </xsl:if>
                    <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore' or
                        ../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='consistenzaSast_show']">
        <tr>
            <td id="testo">
                Oggetti presenti in SAST
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a title="Oggetti Digitali" alt="Oggetti Digitali" id="showScheda">
                        <xsl:if test="../../arr[@name='tipologia_show']/str/child::text()='fondo'">
                            <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />','<xsl:copy-of select="../../arr[@name='bid_show']/str/child::text()" />');</xsl:attribute>
                        </xsl:if>
                        <xsl:if test="../../arr[@name='tipologia_show']/str/child::text()='subFondo'">
                            <xsl:attribute name="onclick">showOgettiDigitaliId('<xsl:copy-of select="../../arr[@name='soggettoConservatoreKey_show']/str/child::text()" />','<xsl:copy-of select="../../arr[@name='fondoKey_show']/str/child::text()" />','<xsl:copy-of select="../../arr[@name='bid_show']/str/child::text()" />');</xsl:attribute>
                        </xsl:if>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='documentiCatografici_show']">
        <tr>
            <td id="testo">
                Documenti cartografici allegati
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('documentiCatografici','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='children_show']">
        <tr>
            <td id="testo">
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore'">
                    Complessi archivistici conservati
                </xsl:if>
                <xsl:if test="../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                    Sotto Livelli
                </xsl:if>
                <xsl:if test="not(../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore') and
                    not(../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                    Collegati
                </xsl:if>
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <xsl:if test="child::text() = 'none'">
                        <xsl:variable name="myPos" select="position()"/>
                        <b>
                            <xsl:copy-of select="../../arr[@name='childrenDesc_show']/str[position() = $myPos]/child::text()"/>
                        </b>
                    </xsl:if>
                    <xsl:if test="not(child::text() = 'none')">
                        <a>
                            <xsl:if test="not(../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore') and
                                not(../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico')">
                                <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            </xsl:if>
                            <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='SoggettoConservatore'">
                                <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='bid_show']/str/child::text()"/>.<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            </xsl:if>
                            <xsl:if test="../../arr[@name='tipologiaFile_show']/str/child::text()='ComplessoArchivistico'">
                                <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='bid_show']/str/child::text()"/>.<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            </xsl:if>
                            <b>
                                <xsl:variable name="myPos" select="position()"/>
                                <xsl:for-each select="//response/result/doc[1]/arr[@name='childrenDesc_show']/str">
                                    <xsl:if test="position()=$myPos">
                                        <xsl:copy-of select="child::text()"/>
                                    </xsl:if>
                                </xsl:for-each>
                            </b>
                        </a>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='note_show']">
        <tr>
            <td id="testo">
                Note
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('note','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                        <b>
                            <xsl:variable name="myPos" select="position()"/>
                            <xsl:for-each select="//response/result/doc[1]/arr[@name='note_show']/str">
                                <xsl:if test="position()=$myPos">
                                    <xsl:copy-of select="child::text()"/>
                                </xsl:if>
                            </xsl:for-each>
                        </b>
                    </a><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='indirizzo_show']">
        <tr>
            <td id="testo">
                Indirizzo
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
    
    <xsl:template match="arr[@name='telefono_show']">
        <tr>
            <td id="testo">
                Telefono
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
    
    <xsl:template match="arr[@name='fax_show']">
        <tr>
            <td id="testo">
                Fax / Cellulare
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
    
    <xsl:template match="arr[@name='estremi_show']">
        <tr>
            <td id="testo">
                Estremi
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <!-- a>
                    <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a --><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='storiaArchivistica_show']">
        <tr>
            <td id="testo">
                Storia Archivistica
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <!-- a>
                    <xsl:attribute name="onclick">findTeca('bid','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a --><br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='soggettoProduttore_show']">
        <tr>
            <td id="testoB">
                Soggetto produttore
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="../../arr[@name='soggettoProduttoreKey_show']/str[position() = $myPos]/child::text()">
                        <xsl:text disable-output-escaping="yes">&amp;nbsp;</xsl:text>
                        <a title="Visualizza Scheda" alt="Visualizza Scheda" id="showScheda">
                            <xsl:attribute name="onclick">showSchedaByBid('<xsl:copy-of select="../../arr[@name='soggettoProduttoreKey_show']/str[position()=$myPos]/child::text()" />');</xsl:attribute>
                            <img alt="Visualizza Scheda" class="objDigit" src="./plugins/content/tecadigitale/images/find.ico"/>
                        </a>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoSoggettoConservatore_show']">
        <tr>
            <td id="testo">
                Tipo Soggetto Conservatore
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
    
    <xsl:template match="arr[@name='email_show']">
        <tr>
            <td id="testo">
                Email
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="href">mailto:<xsl:copy-of select="child::text()" /></xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='servizioPub_show']">
        <tr>
            <td id="testo">
                Servizio consultazione al pubblico
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
    
    <xsl:template match="arr[@name='orarioApertura_show']">
        <tr>
            <td id="testo">
                Orario di Apertura
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
    
    <xsl:template match="arr[@name='schedeConservatori_show']">
        <tr>
            <td id="testo">
                Schede conservatori nei sistemi di provenienza
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="../../arr[@name='schedeConservatoriUrl_show']/str[position() = $myPos]/child::text()">
                        <a>
                            <xsl:attribute name="href"><xsl:copy-of select="../../arr[@name='schedeConservatoriUrl_show']/str[position()=$myPos]/child::text()" /></xsl:attribute>
                            <b>
                                <xsl:copy-of select="child::text()"/>
                            </b>
                        </a>
                    </xsl:if>
                    <xsl:if test="not(../../arr[@name='schedeConservatoriUrl_show']/str[position() = $myPos]/child::text())">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='risorseEsterne_show']">
        <tr>
            <td id="testo">
                Risorse esterne correlate
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <xsl:variable name="myPos" select="position()"/>
                    <xsl:if test="not(../../arr[@name='risorseEsterneUrl_show']/str[position() = $myPos]/child::text() = 'none')">
                        <a>
                            <xsl:attribute name="href"><xsl:copy-of select="../../arr[@name='risorseEsterneUrl_show']/str[position()=$myPos]/child::text()" /></xsl:attribute>
                            <b>
                                <xsl:copy-of select="child::text()"/>
                            </b>
                        </a>
                    </xsl:if>
                    <xsl:if test="../../arr[@name='risorseEsterneUrl_show']/str[position() = $myPos]/child::text() = 'none'">
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </xsl:if>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipologia_show']">
        <tr>
            <td id="testo">
                Tipologia
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
    
    <xsl:template match="arr[@name='sistemaAderente_show']">
        <tr>
            <td id="testo">
                Sistema Aderente
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
    
    <xsl:template match="arr[@name='schedaProvenienzaUrl_show']">
        <tr>
            <td id="testo">
                Scheda Provenienza
            </td>
            <td id="value">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="href"><xsl:copy-of select="child::text()" /></xsl:attribute>
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
</xsl:stylesheet>