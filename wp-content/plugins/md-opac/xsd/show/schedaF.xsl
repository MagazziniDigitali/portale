<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:variable name="apos">'</xsl:variable>  
    <xsl:template match="//scheda">
        <table id="schedaF">
            <tr>
                <td colspan="2" id="viewerImg">
                    <a title="Visualizza Oggetti digitali" id="viewImg">
                        <xsl:attribute name="onclick">showImg('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali" class="objDigit" src="./plugins/content/tecadigitale/images/xlimage/images/object.gif"/>
                        <b>Visualizza Oggetti Digitali</b>
                    </a>
                    <a title="Visualizza Oggetti digitali" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="onclick">showImgPopup('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="./plugins/content/tecadigitale/images/xlimage/images/object_blank.gif"/>
                        <b>Visualizza Oggetti Digitali Finestra Separata</b>
                    </a>
                </td>
            </tr>
            <xsl:apply-templates select="CD"/>
            <xsl:apply-templates select="OG"/>
            <xsl:apply-templates select="SG"/>
            <xsl:apply-templates select="LC"/>
            <xsl:apply-templates select="UB"/>
            <xsl:apply-templates select="DT"/>
            <xsl:apply-templates select="AU"/>
            <xsl:apply-templates select="MT"/>
            <xsl:apply-templates select="CO"/>
            <xsl:apply-templates select="TU"/>
            <xsl:apply-templates select="DO"/>
            <xsl:apply-templates select="AD"/>
            <xsl:apply-templates select="CM"/>
            <xsl:apply-templates select="MC"/>
            <xsl:apply-templates select="MM"/>
            <tr>
                <td colspan="2" id="viewerImg">
                    <a title="Visualizza Oggetti digitali" id="viewImg">
                        <xsl:attribute name="onclick">showImg('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali" class="objDigit" src="./plugins/content/tecadigitale/images/xlimage/images/object.gif"/>
                        <b>Visualizza Oggetti Digitali</b>
                    </a>
                    <a title="Visualizza Oggetti digitali" id="viewImgBlank"  target="_blank">
                        <xsl:attribute name="onclick">showImgPopup('<xsl:copy-of select="id/child::text()" />');</xsl:attribute>
                        <img alt="Visualizza Oggetti Digitali Finestra Separata" class="objDigitBlank" src="./plugins/content/tecadigitale/images/xlimage/images/object_blank.gif"/>
                        <b>Visualizza Oggetti Digitali Finestra Separata</b>
                    </a>
                </td>
            </tr>
        </table>
    </xsl:template>
    
    <xsl:template match="MM">
        <tr>
            <td id="titolo" colspan="2">
                METADATI DATO MULTIMEDIALE
            </td>
        </tr>
        <xsl:if test="MMT">
            <xsl:for-each select="MMT">
                <tr>
                    <td id="subTitolo" colspan="2">
                        METADATI TECNICI DATO MULTIMEDIALE
                    </td>
                </tr>
                <xsl:if test="MMTO">
                    <tr>
                        <td id="subTesto">
                            Nome file originale
                        </td>
                        <td id="value">
                            <xsl:for-each select="MMTO">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="MC">
        <tr>
            <td id="titolo" colspan="2">
                METADATI DI CATALOGAZIONE
            </td>
        </tr>
        <xsl:if test="FTA">
            <xsl:for-each select="FTA">
                <tr>
                    <td id="subTitolo" colspan="2">
                        DOCUMENTAZIONE FOTOGRAFICA
                    </td>
                </tr>
                <xsl:if test="FTAP">
                    <tr>
                        <td id="subTesto">
                            Tipo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAN">
                    <tr>
                        <td id="subTesto">
                            Codice identificativo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="CM">
        <tr>
            <td id="titolo" colspan="2">
                COMPILAZIONE
            </td>
        </tr>
        <xsl:if test="CMP">
            <xsl:for-each select="CMP">
                <tr>
                    <td id="subTitolo" colspan="2">
                        COMPILAZIONE
                    </td>
                </tr>
                <xsl:if test="CMPD">
                    <tr>
                        <td id="subTesto">
                            Data
                        </td>
                        <td id="value">
                            <xsl:for-each select="CMPD">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('dataCompilazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="CMPN">
                    <tr>
                        <td id="subTesto">
                            Nome
                        </td>
                        <td id="value">
                            <xsl:for-each select="CMPN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('compilatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
        <xsl:if test="RSR">
            <tr>
                <td id="testo">
                    Referente scientifico
                </td>
                <td id="value">
                    <xsl:for-each select="RSR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('referenteScientifico','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="FUR">
            <tr>
                <td id="testo">
                    Funzionario responsabile
                </td>
                <td id="value">
                    <xsl:for-each select="FUR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('funzionarioResponsabile','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="AD">
        <tr>
            <td id="titolo" colspan="2">
                ACCESSO AI DATI
            </td>
        </tr>
        <xsl:if test="ADS">
            <xsl:for-each select="ADS">
                <tr>
                    <td id="subTitolo" colspan="2">
                        SPECIFICHE DI ACCESSO AI DATI
                    </td>
                </tr>
                <xsl:if test="ADSP">
                    <tr>
                        <td id="subTesto">
                            Profilo di accesso
                        </td>
                        <td id="value">
                            <xsl:for-each select="ADSP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="ADSM">
                    <tr>
                        <td id="subTesto">
                            Motivazione
                        </td>
                        <td id="value">
                            <xsl:for-each select="ADSM">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="DO">
        <tr>
            <td id="titolo" colspan="2">
                FONTI E DOCUMENTI DI RIFERIMENTO
            </td>
        </tr>
        <xsl:if test="FTA">
            <xsl:for-each select="FTA">
                <tr>
                    <td id="subTitolo" colspan="2">
                        DOCUMENTAZIONE FOTOGRAFICA
                    </td>
                </tr>
                <xsl:if test="FTAX">
                    <tr>
                        <td id="subTesto">
                            Genere
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAX">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAP">
                    <tr>
                        <td id="subTesto">
                            Tipo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAP">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="FTAN">
                    <tr>
                        <td id="subTesto">
                            Codice identificativo
                        </td>
                        <td id="value">
                            <xsl:for-each select="FTAN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="TU">
        <tr>
            <td id="titolo" colspan="2">
                CONDIZIONE GIURIDICA E VINCOLI
            </td>
        </tr>
        <xsl:if test="CDG">
            <xsl:for-each select="CDG">
                <tr>
                    <td id="subTitolo" colspan="2">
                        CONDIZIONE GIURIDICA
                    </td>
                </tr>
                <xsl:if test="CDGG">
                    <tr>
                        <td id="subTesto">
                            Indicazione generica
                        </td>
                        <td id="value">
                            <xsl:for-each select="CDGG">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="CDGS">
                    <tr>
                        <td id="subTesto">
                            Indicazione specifica
                        </td>
                        <td id="value">
                            <xsl:for-each select="CDGS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>

    <xsl:template match="CO">
        <tr>
            <td id="titolo" colspan="2">
                CONSERVAZIONE
            </td>
        </tr>
        <xsl:if test="STC">
            <xsl:for-each select="STC">
                <tr>
                    <td id="subTitolo" colspan="2">
                        STATO DI CONSERVAZIONE
                    </td>
                </tr>
                <xsl:if test="STCC">
                    <tr>
                        <td id="subTesto">
                            Stato di conservazione
                        </td>
                        <td id="value">
                            <xsl:for-each select="STCC">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="STCS">
                    <tr>
                        <td id="subTesto">
                            Indicazioni specifiche
                        </td>
                        <td id="value">
                            <xsl:for-each select="STCS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="MT">
        <tr>
            <td id="titolo" colspan="2">
                DATI TECNICI
            </td>
        </tr>
        <xsl:if test="MTX">
            <tr>
                <td id="testo">
                    Indicazione di colore
                </td>
                <td id="value">
                    <xsl:for-each select="MTX">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="MTC">
            <tr>
                <td id="testo">
                    Materia e tecnica
                </td>
                <td id="value">
                    <xsl:for-each select="MTC">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="MIS">
            <xsl:for-each select="MIS">
                <tr>
                    <td id="subTitolo" colspan="2">
                        MISURE
                    </td>
                </tr>
                <xsl:if test="MISO">
                    <tr>
                        <td id="subTesto">
                            Tipo misure
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISO">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISU">
                    <tr>
                        <td id="subTesto">
                            <xsl:text disable-output-escaping="yes">Unit&amp;agrave; di misura</xsl:text>
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISU">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISA">
                    <tr>
                        <td id="subTesto">
                            Altezza
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISA">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="MISL">
                    <tr>
                        <td id="subTesto">
                            Larghezza
                        </td>
                        <td id="value">
                            <xsl:for-each select="MISL">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="AU">
        <tr>
            <td id="titolo" colspan="2">
                
               DEFINIZIONE CULTURALE
            </td>
        </tr>
        <xsl:if test="AUF">
            <xsl:for-each select="AUF">
                <tr>
                    <td id="subTitolo" colspan="2">
                        AUTORE DELLA FOTOGRAFIA
                    </td>
                </tr>
                <xsl:if test="AUFN">
                    <tr>
                        <td id="subTesto">
                            Nome scelto (persona singola)
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFN">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('autore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFA">
                    <tr>
                        <td id="subTesto">
                            Dati anagrafici/estremi cronologici
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFA">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFR">
                    <tr>
                        <td id="subTesto">
                            Riferimento all'intervento
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFR">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="AUFM">
                    <tr>
                        <td id="subTesto">
                            Motivazione dell'attribuzione
                        </td>
                        <td id="value">
                            <xsl:for-each select="AUFM">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="DT">
        <tr>
            <td id="titolo" colspan="2">
                CRONOLOGIA
            </td>
        </tr>
        <xsl:if test="DTZ">
            <tr>
                <td id="subTitolo" colspan="2">
                    CRONOLOGIA GENERICA
                </td>
            </tr>
            <xsl:if test="DTZ/DTZG">
                <tr>
                    <td id="subTesto">
                        Secolo
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTZ/DTZG">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('secoloIniziale','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="DTS">
            <tr>
                <td id="subTitolo" colspan="2">
                    CRONOLOGIA SPECIFICA
                </td>
            </tr>
            <xsl:if test="DTS/DTSI">
                <tr>
                    <td id="subTesto">
                        Da
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSI">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('data','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSV">
                <tr>
                    <td id="subTesto">
                        <xsl:text disable-output-escaping="yes">Validit&amp;agrave;</xsl:text>
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSV">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSF">
                <tr>
                    <td id="subTesto">
                        A
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSF">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('data','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="DTS/DTSL">
                <tr>
                    <td id="subTesto">
                        <xsl:text disable-output-escaping="yes">Validit&amp;agrave;</xsl:text>
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTS/DTSL">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="DTM">
            <tr>
                <td id="subTitolo" colspan="2">
                    MOTIVAZIONE CRONOLOGIA
                </td>
            </tr>
            <xsl:if test="DTM/DTMM">
                <tr>
                    <td id="subTesto">
                        Motivazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="DTM/DTMM">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="UB">
        <tr>
            <td id="titolo" colspan="2">
                UBICAZIONE E DATI PATRIMONIALI
            </td>
        </tr>
        <xsl:if test="UBF">
            <tr>
                <td id="subTitolo" colspan="2">
                    UBICAZIONE FOTO
                </td>
            </tr>
            <xsl:if test="UBF/UBFP">
                <tr>
                    <td id="subTesto">
                        Fondo
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFP">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('fondo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="UBF/UBFQ">
                <tr>
                    <td id="subTesto">
                        Specifiche
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFQ">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('fondoSpecifiche','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="UBF/UBFC">
                <tr>
                    <td id="subTesto">
                        Collocazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="UBF/UBFC">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>

    <xsl:template match="LC">
        <tr>
            <td id="titolo" colspan="2">
                LOCALIZZAZIONE GEOGRAFICO-AMMINISTRATIVA
            </td>
        </tr>
        <xsl:if test="PVC">
            <tr>
                <td id="subTitolo" colspan="2">
                    LOCALIZZAZIONE GEOGRAFICO-AMMINISTRATIVA ATTUALE
                </td>
            </tr>
            <xsl:if test="PVC/PVCS">
                <tr>
                    <td id="subTesto">
                        Stato
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCS">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('stato','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCR">
                <tr>
                    <td id="subTesto">
                        Regione
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCR">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('regione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCP">
                <tr>
                    <td id="subTesto">
                        Provincia
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCP">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('provincia','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="PVC/PVCC">
                <tr>
                    <td id="subTesto">
                        Comune
                    </td>
                    <td id="value">
                        <xsl:for-each select="PVC/PVCC">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('comune','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="LDC">
            <tr>
                <td id="subTitolo" colspan="2">
                    COLLOCAZIONE SPECIFICA
                </td>
            </tr>
            <xsl:if test="LDC/LDCN">
                <tr>
                    <td id="subTesto">
                        Denominazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:if test="child::text()='non identificabile'">
                                    <xsl:attribute name="onclick">findTeca('denominazione','Archivio Adda');</xsl:attribute>
                                    Archivio Adda
                                </xsl:if>
                                <xsl:if test="not(child::text()='non identificabile')">
                                    <xsl:attribute name="onclick">findTeca('denominazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </xsl:if>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="LDC/LDCU">
                <tr>
                    <td id="subTesto">
                        Denominazione spazio viabilistico
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCU">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('denominazioneIndirizzo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="LDC/LDCM">
                <tr>
                    <td id="subTesto">
                        Denominazione raccolta
                    </td>
                    <td id="value">
                        <xsl:for-each select="LDC/LDCM">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('denominazioneRaccolta','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="SG">
        <tr>
            <td id="titolo" colspan="2">
                SOGGETTO
            </td>
        </tr>
        <xsl:if test="SGT">
            <tr>
                <td id="subTitolo" colspan="2">
                    SOGGETTO
                </td>
            </tr>
            <xsl:if test="SGT/SGTI">
                <tr>
                    <td id="subTesto">
                        Identificazione
                    </td>
                    <td id="value">
                        <xsl:for-each select="SGT/SGTI">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            <a>
                                <xsl:attribute name="onclick">findTeca('soggetto','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                <xsl:copy-of select="child::text()"/>
                            </a>
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="SGT/SGTD">
                <tr>
                    <td id="subTesto">
                        Indicazioni sul soggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="SGT/SGTD">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="SGL">
            <xsl:for-each select="SGL">
                <tr>
                    <td id="subTitolo" colspan="2">
                        TITOLO
                    </td>
                </tr>
                <xsl:if test="SGLT">
                    <tr>
                        <td id="subTesto">
                            Titolo proprio
                        </td>
                        <td id="value">
                            <xsl:for-each select="SGLT">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                <a>
                                    <xsl:attribute name="onclick">findTeca('titolo','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                                    <xsl:copy-of select="child::text()"/>
                                </a>
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <xsl:if test="SGLS">
                    <tr>
                        <td id="subTesto">
                            Specifiche del titolo
                        </td>
                        <td id="value">
                            <xsl:for-each select="SGLS">
                                <xsl:if test="position()>1"><br/></xsl:if>
                                
                                    <xsl:copy-of select="child::text()"/>
                                
                            </xsl:for-each>
                        </td>
                    </tr>
                </xsl:if>
                <tr>
                    <td id="subLineSep" colspan="2"/>
                </tr>
            </xsl:for-each>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="OG">
        <tr>
            <td id="titolo" colspan="2">
                OGGETTO
            </td>
        </tr>
        <xsl:if test="OGT">
            <tr>
                <td id="subTitolo" colspan="2">
                    OGGETTO
                </td>
            </tr>
            <xsl:if test="OGT/OGTD">
                <tr>
                    <td id="subTesto">
                        Definizione dell'oggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="OGT/OGTD">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="OGT/OGTB">
                <tr>
                    <td id="subTesto">
                        Natura biblioteconomica dell'oggetto
                    </td>
                    <td id="value">
                        <xsl:for-each select="OGT/OGTB">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="QNT">
            <tr>
                <td id="subTitolo" colspan="2">
                    <xsl:text disable-output-escaping="yes">QUANTIT&amp;Agrave;</xsl:text>
                </td>
            </tr>
            <xsl:if test="QNT/QNTN">
                <tr>
                    <td id="subTesto">
                        Numero oggetti/elementi
                    </td>
                    <td id="value">
                        <xsl:for-each select="QNT/QNTN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
    </xsl:template>

    <xsl:template match="CD">
        <tr>
            <td id="titolo" colspan="2">
                CODICI
            </td>
        </tr>
        <xsl:if test="TSK">
            <tr>
                <td id="testo">
                    Tipo Scheda
                </td>
                <td id="value">
                    <xsl:for-each select="TSK">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="LIR">
            <tr>
                <td id="testo">
                    Livello ricerca
                </td>
                <td id="value">
                    <xsl:for-each select="LIR">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        
                            <xsl:copy-of select="child::text()"/>
                        
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="NCT">
            <tr>
                <td id="subTitolo" colspan="2">
                    CODICE UNIVOCO
                </td>
            </tr>
            <xsl:if test="NCT/NCTR">
                <tr>
                    <td id="subTesto">
                        Codice regione
                    </td>
                    <td id="value">
                        <xsl:for-each select="NCT/NCTR">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <xsl:if test="NCT/NCTN">
                <tr>
                    <td id="subTesto">
                        Numero catalogo generale
                    </td>
                    <td id="value">
                        <xsl:for-each select="NCT/NCTN">
                            <xsl:if test="position()>1"><br/></xsl:if>
                            
                                <xsl:copy-of select="child::text()"/>
                            
                        </xsl:for-each>
                    </td>
                </tr>
            </xsl:if>
            <tr>
                <td id="subLineSep" colspan="2"/>
            </tr>
        </xsl:if>
        <xsl:if test="ESC">
            <tr>
                <td id="testo">
                    Ente schedatore
                </td>
                <td id="value">
                    <xsl:for-each select="ESC">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('enteSchedatore','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
        <xsl:if test="ECP">
            <tr>
                <td id="testo">
                    Ente competente
                </td>
                <td id="value">
                    <xsl:for-each select="ECP">
                        <xsl:if test="position()>1"><br/></xsl:if>
                        <a>
                            <xsl:attribute name="onclick">findTeca('enteCompetente','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                            <xsl:copy-of select="child::text()"/>
                        </a>
                    </xsl:for-each>
                </td>
            </tr>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>