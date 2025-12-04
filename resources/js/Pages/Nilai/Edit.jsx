import { Button } from "@/Components/ui/button";
import {
    Field,
    FieldError,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSet,
} from "@/Components/ui/field";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Input } from "@/Components/ui/input";
import { useForm } from "@inertiajs/react";
import React from "react";

export default function Edit({ data, mahasiswa, dosen, matakuliah }) {
    const mahasiswaApi = mahasiswa || [];
    const dosenApi = dosen || [];
    const mataKuliahApi = matakuliah || [];

    const {
        data: dataForm,
        setData: setDataForm,
        put,
        processing,
        errors,
        isDirty,
    } = useForm({
        mahasiswa_id: data.mahasiswa_id || "",
        dosen_id: data.dosen_id || "",
        matakuliah_id: data.matakuliah_id || "",
        nilai_angka: data.nilai_angka || "",
        nilai_huruf: data.nilai_huruf || "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        // 4. Gunakan method PUT dan sertakan ID dosen

        if (!isDirty) return;

        put(route("nilai.update", data.id));
        // console.log(dataForm);
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Edit Nilai</FieldLegend>
                    <FieldGroup>
                        <Field>
                            <FieldLabel htmlFor="name">Mahasiswa</FieldLabel>
                            <Select
                                value={dataForm.mahasiswa_id.toString()}
                                onValueChange={(val) => {
                                    setDataForm("mahasiswa_id", val);
                                }}
                            >
                                <SelectTrigger id="name">
                                    <SelectValue placeholder="nama mahasiswa">
                                        {
                                            mahasiswaApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    dataForm.mahasiswa_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {mahasiswaApi &&
                                        mahasiswaApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.mahasiswa_id && (
                                <FieldError>{errors.mahasiswa_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="dosen">Dosen</FieldLabel>
                            <Select
                                value={dataForm.dosen_id.toString()}
                                onValueChange={(val) => {
                                    setDataForm("dosen_id", val);
                                }}
                            >
                                <SelectTrigger id="dosen">
                                    <SelectValue placeholder="nama dosen">
                                        {
                                            dosenApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    dataForm.dosen_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {dosenApi &&
                                        dosenApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.dosen_id && (
                                <FieldError>{errors.dosen_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="mk">Mata Kuliah</FieldLabel>
                            <Select
                                value={dataForm.matakuliah_id.toString()}
                                onValueChange={(val) => {
                                    setDataForm("matakuliah_id", val);
                                }}
                            >
                                <SelectTrigger id="mk">
                                    <SelectValue placeholder="nama mata kuliah">
                                        {
                                            mataKuliahApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    dataForm.matakuliah_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {mataKuliahApi &&
                                        mataKuliahApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.matakuliah_id && (
                                <FieldError>{errors.matakuliah_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nh">Nilai Huruf</FieldLabel>
                            <Input
                                id="nh"
                                autoComplete="off"
                                aria-invalid
                                value={dataForm.nilai_huruf}
                                onChange={(e) =>
                                    setDataForm("nilai_huruf", e.target.value)
                                }
                            />
                            {errors.nilai_huruf && (
                                <FieldError>{errors.nilai_huruf}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nh">Nilai Angka</FieldLabel>
                            <Input
                                id="nh"
                                type="number"
                                autoComplete="off"
                                aria-invalid
                                value={dataForm.nilai_angka}
                                onChange={(e) =>
                                    setDataForm("nilai_angka", e.target.value)
                                }
                            />
                            {errors.nilai_angka && (
                                <FieldError>{errors.nilai_angka}</FieldError>
                            )}
                        </Field>
                        <Button
                            type="button"
                            onClick={() => window.history.back()}
                        >
                            kembali
                        </Button>
                        <Button type="submit" disabled={processing || !isDirty}>
                            Update
                        </Button>
                    </FieldGroup>
                </FieldSet>
            </form>
        </div>
    );
}
