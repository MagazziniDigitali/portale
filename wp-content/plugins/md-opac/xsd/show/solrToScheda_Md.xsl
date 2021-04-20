<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="solrToScheda_Sast.xsl"/>
    
    <xsl:template match="arr[@name='provenienzaOggetto_show']">
        <tr>
            <td id="testoB">
                Provenienza Oggetto
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                        <b>
                            <xsl:copy-of select="child::text()"/>
                        </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoContenitore_show']">
        <tr>
            <td id="testoB">
                Tipo Contenitore
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='objectIdentifier_show']">
        <tr>
            <td id="testoB">
                Object Identifier
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='fileType_show']">
        <tr>
            <td id="testoB">
                File Type
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='actualFileName_show']">
        <tr>
            <td id="testoB">
                Actual File Name
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='sha1_show']">
        <tr>
            <td id="testoB">
                Sha1
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='size_show']">
        <tr>
            <td id="testoB">
                Size
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='mimeType_show']">
        <tr>
            <td id="testoB">
                Mime Type
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='promon_show']">
        <tr>
            <td id="testoB">
                Pronom
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='rights_show']">
        <tr>
            <td id="testoB">
                Rights
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                    <b>
			<xsl:if test="../../rights">
				 <xsl:copy-of select="../../rights/child::text()"/>
			</xsl:if>
			<xsl:if test="not(../../rights)">
                        	<xsl:copy-of select="child::text()"/>
			</xsl:if>
                    </b>
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tarIndex_show']">
        <tr>
            <td id="testoB">
                Tar Index
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='relationshipType_show']">
        <tr>
            <td id="testoB">
                RelationShip Type
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventID_show']">
        <tr>
            <td id="testoB">
                Event ID
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventType_show']">
        <tr>
            <td id="testoB">
                Event Type
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventDate_show']">
        <tr>
            <td id="testoB">
                Event Date
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventDetail_show']">
        <tr>
            <td id="testoB">
                Event Detail
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventOutCome_show']">
        <tr>
            <td id="testoB">
                Event Out Come
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentDepositante_show']">
        <tr>
            <td id="testoB">
                Agent Depositante
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('id','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentSoftware_show']">
        <tr>
            <td id="testoB">
                Agent Software
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='nodo_show']">
        <tr>
            <td id="testoB">
                Nodo
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoDocumento_show']">
        <tr>
            <td id="testoB">
                Tipo Documento
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='bni_show']">
        <tr>
            <td id="testoB">
                Bni
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='pubblicazione_show']">
        <tr>
            <td id="testoB">
                Luogo di pubblicazione
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='soggetto_show']">
        <tr>
            <td id="testoB">
                Soggetto
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='contributo_show']">
        <tr>
            <td id="testoB">
                Contributo
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='data_show']">
        <tr>
            <td id="testoB">
                Data Pubblicazione
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tiporisorsa_show']">
        <tr>
            <td id="testoB">
                Tipo Risorsa
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='formato_show']">
        <tr>
            <td id="testoB">
                Formato
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='fonte_show']">
        <tr>
            <td id="testoB">
                Fonte
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='relazione_show']">
        <tr>
            <td id="testoB">
                Relazione
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='copertura_show']">
        <tr>
            <td id="testoB">
                Copertura
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='gestionediritti_show']">
        <tr>
            <td id="testoB">
                Gestione Diritti
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='biblioteca_show']">
        <tr>
            <td id="testoB">
                Biblioteca
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='inventario_show']">
        <tr>
            <td id="testoB">
                Inventario
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecegr_show']">
        <tr>
            <td id="testoB">
                Piece gr
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecedt_show']">
        <tr>
            <td id="testoB">
                Pice Dt
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecein_show']">
        <tr>
            <td id="testoB">
                Piece In
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='indexed_show']">
        <tr>
            <td id="testoB">
                Data ora Indicizzazione
            </td>
            <td id="valueB">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    <b>
                        <xsl:copy-of select="child::text()"/>
                    </b>
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
